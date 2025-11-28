<?php
class LayananController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ: Ambil Semua Layanan
    public function getAllLayanan() {
        $query = "SELECT * FROM jenis_layanan ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ: Ambil 1 Layanan (Untuk Edit)
    public function getLayananById($id) {
        $query = "SELECT * FROM jenis_layanan WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // CREATE: Tambah Layanan Baru
    public function createLayanan($nama, $kode, $syarat) {
        // Cek kode unik
        $check = "SELECT id FROM jenis_layanan WHERE kode_surat = :kode";
        $stmtCheck = $this->conn->prepare($check);
        $stmtCheck->execute([':kode' => $kode]);
        if($stmtCheck->rowCount() > 0) return "Kode Surat sudah digunakan!";

        $query = "INSERT INTO jenis_layanan (nama_layanan, kode_surat, syarat_dokumen, is_active) 
                  VALUES (:nama, :kode, :syarat, 1)";
        
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([':nama' => $nama, ':kode' => $kode, ':syarat' => $syarat])) {
            return true;
        }
        return "Gagal menyimpan data.";
    }

    // UPDATE: Ubah Layanan
    public function updateLayanan($id, $nama, $kode, $syarat) {
        $query = "UPDATE jenis_layanan SET nama_layanan = :nama, kode_surat = :kode, syarat_dokumen = :syarat 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':nama' => $nama, ':kode' => $kode, ':syarat' => $syarat, ':id' => $id]);
    }

    // DELETE: Hapus Layanan
    public function deleteLayanan($id) {
        try {
            $query = "DELETE FROM jenis_layanan WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return "Gagal: Layanan ini sudah digunakan dalam permohonan surat.";
        }
    }
}
?>