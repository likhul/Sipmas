# SIPMAS - Sistem Informasi Pelayanan Masyarakat
Desa Simpang Sungai Duren

Final Project Rekayasa Perangkat Lunak
Kelompok: 2
Anggota:
1. Eka Saputra (701230018)
2. Adi Saputra (701230020)
3. Solikul Hadi (701230145)

Dosen Pengampu: Dila Nurlaila, M.Kom.
---

## 📝 Deskripsi Aplikasi
SIPMAS adalah aplikasi pelayanan publik berbasis web yang dirancang khusus untuk Kantor Desa Simpang Sungai Duren. Aplikasi ini mendigitalkan proses administrasi desa, mulai dari pengelolaan data kependudukan, pengajuan surat menyurat secara mandiri oleh warga, hingga penanganan pengaduan masyarakat dalam satu platform terintegrasi.

## 🎯 Tujuan & Masalah yang Diselesaikan
Masalah: Proses pengajuan surat yang mengharuskan warga datang berkali-kali ke kantor desa, antrean manual, pendataan penduduk yang belum terpusat, serta arsip surat yang masih konvensional (rawan hilang).
Solusi: SIPMAS menyediakan portal pelayanan mandiri di mana Warga dapat mengajukan surat (SKU, SKCK, dll) dari rumah, memantau status verifikasi, dan menyampaikan aspirasi. Bagi Perangkat Desa, aplikasi ini mempermudah verifikasi surat, manajemen data penduduk, dan pelaporan arsip secara digital.

## 🛠 Teknologi yang Digunakan
Language: PHP Native (MVC Architecture) 
Styling: CSS
Frontend: HTML, JavaScript
Database: MySQL
Server: Apache (XAMPP for Local)
Hosting:** InfinityFree

## 💻 Cara Menjalankan Aplikasi (Lokal)
1.   Clone / Download Repository
     Simpan folder project sipmas ke dalam folder htdocs (jika menggunakan XAMPP).
2.   Import Database
     Buka phpMyAdmin (http://localhost/phpmyadmin).
     Buat database baru dengan nama sipmas_db.
     Import file database sipmas.sql yang ada di folder project.
3.   Konfigurasi Koneksi
     Sesuaikan konfigurasi database di file koneksi.php atau config.php (sesuaikan username dan password database lokal Anda).
4.   Jalankan Project**
     Pastikan Apache dan MySQL di XAMPP sudah berjalan (Start).
     Buka browser dan akses: http://localhost/sipmas

## 🔐 Akun Demo (Untuk Pengujian)
Berikut adalah akun yang dapat digunakan untuk menguji berbagai role dalam sistem:

AKUN LOGIN DEMO:

1. ADMIN (Verifikasi & Kelola Data)
   Email: admin@desa.id
   Pass : 123456

2. KEPALA DESA (Persetujuan Surat)
   Email: kades@desa.id
   Pass : 123456

3. WARGA (Pengajuan Surat)
   Email: likhulhadi2@gmail.com
   Pass : 123456

## 🌐 Link Deployment & Demo
Aplikasi Web: [http://sipmas2.infinityfree.me]

## 📸 Screenshot
<img src="SIPMAS_1/assets/images/Admin.png"

## 📝 Catatan Tambahan
- Fitur "Cetak Surat" akan menghasilkan file dalam format PDF/Direct Print yang sudah dilengkapi dengan format resmi desa.
- Status surat mencakup: Menunggu Verifikasi, Disetujui/Siap Cetak, dan Ditolak.

---
Dibuat untuk memenuhi tugas Final Project mata kuliah Rekayasa Perangkat Lunak, Program Studi Sistem Informasi, UIN Sultan Thaha Saifuddin Jambi, 2025.**