<?php
class PermohonanController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- FITUR UMUM ---
    public function getDaftarLayanan() {
        $stmt = $this->conn->prepare("SELECT * FROM jenis_layanan WHERE is_active = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // AJUKAN SURAT (DENGAN VALIDASI FILE)
    public function ajukanSurat($userId, $layananId, $dataInput, $fileInfo) {
        try {
            $this->conn->beginTransaction();
            $tiket = "TIKET-" . date('Ymd') . "-" . rand(1000,9999);
            $stmt = $this->conn->prepare("INSERT INTO permohonan (user_id, layanan_id, nomor_tiket, data_pengaju, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())");
            $stmt->execute([$userId, $layananId, $tiket, json_encode($dataInput)]);
            $permohonanId = $this->conn->lastInsertId();

            // Validasi File
            $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf','jpg','jpeg','png'])) { 
                $this->conn->rollBack(); return false; 
            }

            if ($fileInfo['error'] === UPLOAD_ERR_OK) {
                $target = 'assets/uploads/DOC-' . $permohonanId . '-' . time() . '.' . $ext;
                if (move_uploaded_file($fileInfo['tmp_name'], $target)) {
                    $stmtDoc = $this->conn->prepare("INSERT INTO dokumen_pendukung (permohonan_id, nama_file, path_file) VALUES (?, ?, ?)");
                    $stmtDoc->execute([$permohonanId, $fileInfo['name'], $target]);
                }
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) { $this->conn->rollBack(); return false; }
    }

    public function getRiwayatUser($userId) {
        // Fix: Join ke surat_digital untuk ambil nomor resmi
        $query = "SELECT p.*, l.nama_layanan, sd.nomor_surat_resmi 
                  FROM permohonan p 
                  JOIN jenis_layanan l ON p.layanan_id = l.id 
                  LEFT JOIN surat_digital sd ON sd.permohonan_id = p.id
                  WHERE p.user_id = ? 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // --- FITUR ADMIN / KADES ---
    public function getPermohonanByStatus($status) {
        // Fix: Hanya tampilkan yang belum diarsip (status_arsip = 0)
        $query = "SELECT p.*, u.nama_lengkap as nama_pemohon, l.nama_layanan, sd.nomor_surat_resmi 
                  FROM permohonan p 
                  JOIN users u ON p.user_id = u.id 
                  JOIN jenis_layanan l ON p.layanan_id = l.id 
                  LEFT JOIN surat_digital sd ON sd.permohonan_id = p.id
                  WHERE p.status = ? AND (p.status_arsip = 0 OR p.status_arsip IS NULL)
                  ORDER BY p.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }

    public function getDetailPermohonan($id) {
        $sql = "SELECT p.*, u.nama_lengkap, u.nik, u.alamat, l.nama_layanan, l.kode_surat,
                       sd.nomor_surat_resmi, sd.tanggal_dibuat as tgl_surat
                FROM permohonan p
                JOIN users u ON p.user_id = u.id
                JOIN jenis_layanan l ON p.layanan_id = l.id
                LEFT JOIN surat_digital sd ON sd.permohonan_id = p.id
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        if ($data) {
            $stmtDoc = $this->conn->prepare("SELECT * FROM dokumen_pendukung WHERE permohonan_id = ?");
            $stmtDoc->execute([$id]);
            $data->dokumen = $stmtDoc->fetchAll();
        }
        return $data;
    }

    public function prosesVerifikasiAdmin($id, $adminId, $aksi, $alasan = null) {
        $status = ($aksi == 'terima') ? 'menunggu_kades' : 'ditolak';
        $sql = "UPDATE permohonan SET status = ?, diverifikasi_oleh_admin_id = ?, keterangan_status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $adminId, $alasan, $id]);
    }

    public function approvalKades($id, $kadesId) {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare("UPDATE permohonan SET status = 'disetujui', disetujui_oleh_kades_id = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$kadesId, $id]);

            $stmtInfo = $this->conn->prepare("SELECT l.kode_surat FROM permohonan p JOIN jenis_layanan l ON p.layanan_id = l.id WHERE p.id = ?");
            $stmtInfo->execute([$id]);
            $info = $stmtInfo->fetch();
            
            $nomorResmi = "140 / " . str_pad($id, 3, '0', STR_PAD_LEFT) . " / " . $info->kode_surat . " / " . date('Y');

            $sqlSurat = "INSERT INTO surat_digital (permohonan_id, nomor_surat_resmi, isi_surat, tanggal_dibuat) VALUES (?, ?, ?, NOW())";
            $stmtSurat = $this->conn->prepare($sqlSurat);
            $stmtSurat->execute([$id, $nomorResmi, 'Surat Resmi Digital']);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // --- ARSIP (INI YANG TADI MISSING/HILANG) ---
    public function arsipkanSurat($id) {
        try {
            $query = "UPDATE permohonan SET status_arsip = 1 WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getArsip() {
        $query = "SELECT p.*, u.nama_lengkap, l.nama_layanan 
                  FROM permohonan p
                  JOIN users u ON p.user_id = u.id
                  JOIN jenis_layanan l ON p.layanan_id = l.id
                  WHERE p.status_arsip = 1
                  ORDER BY p.updated_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // --- LAPORAN ---
    public function getLaporan($tglAwal, $tglAkhir, $status = null) {
        $sql = "SELECT p.*, u.nama_lengkap, u.nik, l.nama_layanan FROM permohonan p JOIN users u ON p.user_id = u.id JOIN jenis_layanan l ON p.layanan_id = l.id WHERE DATE(p.created_at) BETWEEN ? AND ? " . ($status ? "AND p.status = ?" : "") . " ORDER BY p.created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $params = [$tglAwal, $tglAkhir];
        if ($status) $params[] = $status;
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>