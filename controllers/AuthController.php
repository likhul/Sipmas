<?php
class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        // Ambil user berdasarkan email
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        // Verifikasi Password
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['role'] = $user->role;
            $_SESSION['nama'] = $user->nama_lengkap;
            $_SESSION['email'] = $user->email;
            return true;
        }
        return false;
    }

    public function register($nik, $nama, $email, $password, $alamat) {
        if (!ctype_digit($nik)) {
            return "Format NIK tidak valid! Hanya boleh berisi angka.";
        }
        if (strlen($nik) != 16) {
            return "NIK harus tepat 16 digit angka.";
        }
        // Cek apakah email/NIK sudah ada
        $check = "SELECT id FROM users WHERE email = :email OR nik = :nik";
        $stmtCheck = $this->conn->prepare($check);
        $stmtCheck->execute([':email'=>$email, ':nik'=>$nik]);
        if($stmtCheck->rowCount() > 0) return "Email atau NIK sudah terdaftar!";

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert Warga Baru
        $query = "INSERT INTO users (role, nik, nama_lengkap, email, password, alamat, status_akun) 
                  VALUES ('masyarakat', :nik, :nama, :email, :pass, :alamat, 1)";
        $stmt = $this->conn->prepare($query);
        
        if($stmt->execute([
            ':nik' => $nik,
            ':nama' => $nama,
            ':email' => $email,
            ':pass' => $hashed_password,
        ])) {
            return true;
        }
        return "Gagal mendaftar, coba lagi.";
    }
}
?>