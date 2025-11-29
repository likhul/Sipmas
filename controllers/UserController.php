<?php
class UserController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllMasyarakat($keyword = null) {
        $sql = "SELECT * FROM users WHERE role = 'masyarakat'";
        
        if ($keyword) {
            $sql .= " AND (nama_lengkap LIKE :kw OR nik LIKE :kw)";
        }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        if ($keyword) {
            $stmt->bindValue(':kw', "%$keyword%");
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ambil User Internal (Admin & Kades)
    public function getUsersByRole($role) {
        if ($role == 'internal') {
            $query = "SELECT * FROM users WHERE role IN ('admin', 'kades') ORDER BY role, nama_lengkap ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } else {
            $query = "SELECT * FROM users WHERE role = :role ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':role' => $role]);
        }
        return $stmt->fetchAll();
    }

    // Ambil 1 User by ID (Untuk Edit)
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Tambah User Baru (Masyarakat / Admin / Kades)
    public function createUser($data) {
        $check = "SELECT id FROM users WHERE email = :email";
        if (!empty($data['nik'])) { $check .= " OR nik = :nik"; }
        
        $stmtCheck = $this->conn->prepare($check);
        $paramsCheck = [':email' => $data['email']];
        if (!empty($data['nik'])) $paramsCheck[':nik'] = $data['nik'];
        $stmtCheck->execute($paramsCheck);
        
        if($stmtCheck->rowCount() > 0) return "Email atau NIK sudah terdaftar!";

        $hash = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO users (role, nik, nama_lengkap, email, password, alamat, no_hp, jabatan, status_akun, status_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, status_perkawinan, pekerjaan) 
                  VALUES (:role, :nik, :nama, :email, :pass, :alamat, :hp, :jabatan, 1, 'Tetap', :tmp_lahir, :tgl_lahir, :jk, :agama, :kawin, :kerja)";
        
        $stmt = $this->conn->prepare($query);
        $exec = $stmt->execute([
            ':role' => $data['role'],
            ':nik' => $data['nik'] ?? null,
            ':nama' => $data['nama'],
            ':email' => $data['email'],
            ':pass' => $hash,
            ':alamat' => $data['alamat'],
            ':hp' => $data['hp'],
            ':jabatan' => $data['jabatan'] ?? null,
            ':tmp_lahir' => $data['tempat_lahir'] ?? null,
            ':tgl_lahir' => $data['tanggal_lahir'] ?? null,
            ':jk' => $data['jenis_kelamin'] ?? null,
            ':agama' => $data['agama'] ?? null,
            ':kawin' => $data['status_perkawinan'] ?? null,
            ':kerja' => $data['pekerjaan'] ?? null
        ]);

        return $exec ? true : "Gagal menyimpan data.";
    }

    // UPDATE 
    public function updateUser($data) {
        try {
            $sql = "UPDATE users SET nama_lengkap=:nama, email=:email, alamat=:alamat, no_hp=:hp, jabatan=:jabatan,
                    tempat_lahir=:tmp_lahir, tanggal_lahir=:tgl_lahir, jenis_kelamin=:jk, agama=:agama, 
                    status_perkawinan=:kawin, pekerjaan=:kerja";

            $params = [
                ':nama' => $data['nama'], ':email' => $data['email'], ':alamat' => $data['alamat'], ':hp' => $data['hp'], 
                ':jabatan' => $data['jabatan'] ?? null, 
                ':tmp_lahir' => $data['tempat_lahir'] ?? null, ':tgl_lahir' => $data['tanggal_lahir'] ?? null,
                ':jk' => $data['jenis_kelamin'] ?? null, ':agama' => $data['agama'] ?? null,
                ':kawin' => $data['status_perkawinan'] ?? null, ':kerja' => $data['pekerjaan'] ?? null,
                ':id' => $data['id']
            ];

            if(isset($data['status_kependudukan'])) {
                $sql .= ", status_kependudukan=:status_kependudukan";
                $params[':status_kependudukan'] = $data['status_kependudukan'];
            }
            if(isset($data['nik'])) {
                $sql .= ", nik=:nik";
                $params[':nik'] = $data['nik'];
            }
            if (!empty($data['password'])) {
                $sql .= ", password=:pass";
                $params[':pass'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }

            $sql .= " WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("ERROR SQL PASTI: " . $e->getMessage()); 
        }
    }

    // Hapus User
    public function deleteUser($id) {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return "Gagal: User memiliki data terkait (Surat/Laporan) yang tidak boleh hilang.";
        }
    }

    public function deletePenduduk($id) {
        return $this->deleteUser($id);
    }

    // Update Profil Diri Sendiri
    public function updateProfile($id, $nama, $email, $hp, $alamat, $password = null) {
        $data = [
            'id' => $id, 'nama' => $nama, 'email' => $email, 
            'hp' => $hp, 'alamat' => $alamat, 'password' => $password
        ];
        return $this->updateUser($data) ? true : "Gagal memperbarui profil.";
    }

    //FITUR PENGADUAN 
    public function simpanPengaduan($uid, $subjek, $isi) {
        $sql = "INSERT INTO pengaduan (user_id, subjek, isi_pengaduan) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$uid, $subjek, $isi]);
    }

    public function getPengaduanUser($uid) {
        $sql = "SELECT * FROM pengaduan WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$uid]);
        return $stmt->fetchAll();
    }

    public function getAllPengaduan() {
        $sql = "SELECT p.*, u.nama_lengkap FROM pengaduan p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function updateStatusPengaduan($id, $status) {
        $sql = "UPDATE pengaduan SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    //FITUR RESET PASSWORD ADMIN
    public function resetPasswordUser($id, $newPass) {
        $hash = password_hash($newPass, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$hash, $id]);
    }

    //FITUR MUTASI PENDUDUK
    public function catatMutasi($userId, $jenis, $tanggal, $keterangan) {
        try {
            $this->conn->beginTransaction();

            // 1. Simpan ke Log Mutasi
            $sqlLog = "INSERT INTO mutasi_penduduk (user_id, jenis_mutasi, tanggal_mutasi, keterangan) VALUES (?, ?, ?, ?)";
            $stmtLog = $this->conn->prepare($sqlLog);
            $stmtLog->execute([$userId, $jenis, $tanggal, $keterangan]);

            // 2. Update Status di Tabel Users
            $statusUser = ($jenis == 'Masuk') ? 'Tetap' : (($jenis == 'Keluar') ? 'Pindah' : 'Meninggal');
            $sqlUpdate = "UPDATE users SET status_kependudukan = ? WHERE id = ?";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([$statusUser, $userId]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getRiwayatMutasi() {
        $sql = "SELECT m.*, u.nama_lengkap, u.nik FROM mutasi_penduduk m JOIN users u ON m.user_id = u.id ORDER BY m.tanggal_mutasi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>