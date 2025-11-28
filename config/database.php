<?php
class Database {
    private $host = "localhost";
    private $db_name = "sipmas_db"; // Sesuaikan nama DB Anda
    private $username = "root";     // Default XAMPP/Laragon
    private $password = "";         // Default kosong
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Mode Error Exception: Wajib untuk debugging profesional
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Default fetch ke Object agar lebih rapi (seperti Firebase document)
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $exception) {
            // Dalam produksi, jangan echo error raw ke user. Log ke file.
            die("Database Connection Error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>