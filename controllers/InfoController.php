<?php
class InfoController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ: Ambil Semua Informasi
    public function getAllInfo() {
        $query = "SELECT i.*, u.nama_lengkap as penulis 
                  FROM informasi i
                  JOIN users u ON i.created_by = u.id
                  ORDER BY i.tanggal_posting DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ: Ambil 1 Info
    public function getInfoById($id) {
        $query = "SELECT * FROM informasi WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // CREATE: Posting Baru
    public function createInfo($judul, $kategori, $isi, $adminId) {
        $query = "INSERT INTO informasi (judul, kategori, isi_konten, created_by, tanggal_posting) 
                  VALUES (:judul, :kat, :isi, :aid, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':judul' => $judul, ':kat' => $kategori, ':isi' => $isi, ':aid' => $adminId
        ]);
    }

    // UPDATE: Simpan Perubahan 
    public function updateInfo($id, $judul, $kategori, $isi) {
        $query = "UPDATE informasi SET judul = :judul, kategori = :kat, isi_konten = :isi WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':judul' => $judul, ':kat' => $kategori, ':isi' => $isi, ':id' => $id
        ]);
    }

    // DELETE: Hapus
    public function deleteInfo($id) {
        $query = "DELETE FROM informasi WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
?>