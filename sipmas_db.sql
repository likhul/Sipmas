-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Nov 2025 pada 16.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipmas_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_pendukung`
--

CREATE TABLE `dokumen_pendukung` (
  `id` int(11) NOT NULL,
  `permohonan_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tipe_dokumen` varchar(50) DEFAULT 'Lampiran',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokumen_pendukung`
--

INSERT INTO `dokumen_pendukung` (`id`, `permohonan_id`, `nama_file`, `path_file`, `tipe_dokumen`, `uploaded_at`) VALUES
(4, 8, 'Screenshot 2025-10-15 194152.png', 'assets/uploads/DOC-8-1764319391.png', 'Lampiran', '2025-11-28 08:43:11'),
(5, 9, 'Screenshot 2025-10-15 194807.png', 'assets/uploads/DOC-9-1764319509.png', 'Lampiran', '2025-11-28 08:45:09'),
(6, 10, 'Screenshot 2025-10-19 145913.png', 'assets/uploads/DOC-10-1764319609.png', 'Lampiran', '2025-11-28 08:46:49'),
(7, 11, 'Screenshot 2025-10-19 145913.png', 'assets/uploads/DOC-11-1764320379.png', 'Lampiran', '2025-11-28 08:59:39'),
(8, 12, 'Screenshot 2025-10-21 211543.png', 'assets/uploads/DOC-12-1764399532.png', 'Lampiran', '2025-11-29 06:58:52'),
(9, 13, 'Screenshot 2025-10-19 140306.png', 'assets/uploads/DOC-13-1764419855.png', 'Lampiran', '2025-11-29 12:37:35'),
(10, 14, 'Screenshot 2025-10-15 194807.png', 'assets/uploads/DOC-14-1764424308-0.png', 'Lampiran', '2025-11-29 13:51:48'),
(11, 15, 'Screenshot 2025-10-15 194807.png', 'assets/uploads/DOC-15-1764426862-0.png', 'Lampiran', '2025-11-29 14:34:22'),
(12, 16, 'Screenshot 2025-10-15 194807.png', 'assets/uploads/DOC-16-1764427646-0.png', 'Lampiran', '2025-11-29 14:47:26'),
(13, 17, 'WhatsApp_Image_2025-11-28_at_14.02.56_6e3f4e00-removebg-preview.png', 'assets/uploads/DOC-17-1764430134-0.png', 'Lampiran', '2025-11-29 15:28:54'),
(14, 18, 'WhatsApp Image 2025-11-28 at 14.02.56_6e3f4e00.jpg', 'assets/uploads/DOC-18-1764430238-0.jpg', 'Lampiran', '2025-11-29 15:30:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kategori` enum('Pengumuman','Berita','Jadwal') NOT NULL,
  `isi_konten` text NOT NULL,
  `tanggal_posting` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `informasi`
--

INSERT INTO `informasi` (`id`, `judul`, `kategori`, `isi_konten`, `tanggal_posting`, `created_by`) VALUES
(1, 'Jadwal Pelayanan Kantor Desa Simpang Sungai Duren', 'Pengumuman', 'Pelayanan kantor desa buka setiap hari Senin - Jumat pukul 08.00 - 16.00 WIB.', '2025-11-28 00:19:26', 1),
(2, 'Kerja Bakti Minggu Ini', 'Jadwal', 'Diharapkan kehadiran warga RT 01 dan 02 untuk kerja bakti membersihkan selokan pada hari Minggu.', '2025-11-28 00:19:26', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_layanan`
--

CREATE TABLE `jenis_layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `kode_surat` varchar(20) NOT NULL,
  `syarat_dokumen` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_layanan`
--

INSERT INTO `jenis_layanan` (`id`, `nama_layanan`, `kode_surat`, `syarat_dokumen`, `is_active`) VALUES
(1, 'Surat Keterangan Usaha', 'SKU', '[\"KTP\", \"Foto Lokasi Usaha\"]', 1),
(2, 'Surat Keterangan Domisili', 'SKD', '[\"KTP\", \"Kartu Keluarga\"]', 1),
(3, 'Surat Pengantar SKCK', 'SKCK', '[\"KTP\", \"KK\", \"Akta Kelahiran\"]', 1),
(4, 'Surat Keterangan Tidak Mampu ', 'SKTM', '[\"KTP\", \"KK\", \"Surat Pengantar RT\"]', 1),
(5, 'Surat Keterangan Kelahiran', 'LHR', '[\"KTP Orang Tua\", \"KK\", \"Surat Bidan/Rumah Sakit\"]', 1),
(6, 'Surat Keterangan Kematian', 'KMT', '[\"KTP Almarhum\", \"KK\", \"Surat Pengantar RT\"]', 1),
(7, 'Surat Pengantar Nikah ', 'NKH', '[\"KTP\", \"KK\", \"Akte Kelahiran\", \"Ijazah Terakhir\", \"Pas Foto 2x3\"]', 1),
(8, 'Surat Izin Keramaian', 'IZN', '[\"KTP Penanggung Jawab\", \"Surat Pernyataan\", \"Jadwal Acara\"]', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_penduduk`
--

CREATE TABLE `mutasi_penduduk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jenis_mutasi` enum('Masuk','Keluar','Meninggal') NOT NULL,
  `tanggal_mutasi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mutasi_penduduk`
--

INSERT INTO `mutasi_penduduk` (`id`, `user_id`, `jenis_mutasi`, `tanggal_mutasi`, `keterangan`, `created_at`) VALUES
(2, 6, 'Masuk', '2025-11-29', 'Pindah ke Jambi karena kerja', '2025-11-29 12:25:58'),
(3, 6, 'Keluar', '2025-11-29', 'Keluar ke Jambi karena kerja', '2025-11-29 12:51:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subjek` varchar(150) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `status` enum('Terkirim','Dibaca','Selesai') DEFAULT 'Terkirim',
  `tanggapan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `subjek`, `isi_pengaduan`, `status`, `tanggapan_admin`, `created_at`) VALUES
(2, 4, 'Jalan Rusak disini', 'secepatnya pak', 'Dibaca', NULL, '2025-11-28 08:44:14'),
(4, 5, 'Keramaian', 'Ada keributan disini', 'Selesai', NULL, '2025-11-29 12:56:31'),
(5, 5, 'jalan rusak', 'rusak banget nih', 'Selesai', NULL, '2025-11-29 12:56:47'),
(6, 5, 'Lampu Mati', 'Lampu Mati di RT 09', 'Terkirim', NULL, '2025-11-29 13:40:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan`
--

CREATE TABLE `permohonan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `layanan_id` int(11) NOT NULL,
  `nomor_tiket` varchar(50) NOT NULL,
  `data_pengaju` text DEFAULT NULL,
  `status` enum('pending','verifikasi_admin','menunggu_kades','disetujui','ditolak','selesai') DEFAULT 'pending',
  `diverifikasi_oleh_admin_id` int(11) DEFAULT NULL,
  `disetujui_oleh_kades_id` int(11) DEFAULT NULL,
  `ditolak_oleh_admin_id` int(11) DEFAULT NULL,
  `keterangan_status` text DEFAULT NULL,
  `status_arsip` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permohonan`
--

INSERT INTO `permohonan` (`id`, `user_id`, `layanan_id`, `nomor_tiket`, `data_pengaju`, `status`, `diverifikasi_oleh_admin_id`, `disetujui_oleh_kades_id`, `ditolak_oleh_admin_id`, `keterangan_status`, `status_arsip`, `created_at`, `updated_at`) VALUES
(8, 4, 1, 'TIKET-20251128-4352', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 1, '2025-11-28 08:43:11', '2025-11-29 05:46:57'),
(9, 4, 3, 'TIKET-20251128-1506', '{\"keperluan\":\"untuk membuat skck\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 1, '2025-11-28 08:45:09', '2025-11-29 12:20:03'),
(10, 4, 2, 'TIKET-20251128-3845', '{\"keperluan\":\"PIndah Alamat\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-28 08:46:49', '2025-11-28 08:53:18'),
(11, 4, 1, 'TIKET-20251128-5667', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 1, '2025-11-28 08:59:39', '2025-11-29 13:53:46'),
(12, 4, 7, 'REG-20251129-1430', '{\"keperluan\":\"mengajukan surat\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-29 06:58:52', '2025-11-29 08:08:03'),
(13, 5, 1, 'REG-20251129-2777', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-29 12:37:35', '2025-11-29 12:47:17'),
(14, 5, 8, 'REG-20251129-9439', '{\"keperluan\":\"Untuk membuat keramaian\",\"keterangan\":\"\"}', 'ditolak', 1, NULL, NULL, 'Syarat tidak sesuai', 0, '2025-11-29 13:51:48', '2025-11-29 13:53:37'),
(15, 5, 1, 'REG-20251129-3095', '{\"keperluan\":\"kerja\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-29 14:34:22', '2025-11-29 15:28:08'),
(16, 5, 3, 'REG-20251129-7817', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'menunggu_kades', 1, NULL, NULL, NULL, 0, '2025-11-29 14:47:26', '2025-11-29 14:52:45'),
(17, 5, 1, 'REG-20251129-1433', '{\"keperluan\":\"kerja\",\"keterangan\":\"\"}', 'pending', NULL, NULL, NULL, NULL, 0, '2025-11-29 15:28:54', '2025-11-29 15:28:54'),
(18, 5, 4, 'REG-20251129-7922', '{\"keperluan\":\"kerja\",\"keterangan\":\"\"}', 'menunggu_kades', 1, NULL, NULL, NULL, 0, '2025-11-29 15:30:38', '2025-11-29 15:31:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_digital`
--

CREATE TABLE `surat_digital` (
  `id` int(11) NOT NULL,
  `permohonan_id` int(11) NOT NULL,
  `nomor_surat_resmi` varchar(100) NOT NULL,
  `isi_surat` text NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_digital`
--

INSERT INTO `surat_digital` (`id`, `permohonan_id`, `nomor_surat_resmi`, `isi_surat`, `tanggal_dibuat`) VALUES
(1, 8, '140 / 008 / SKU / 2025', 'Surat Resmi Digital', '2025-11-28 08:53:15'),
(2, 10, '140 / 010 / SKD / 2025', 'Surat Resmi Digital', '2025-11-28 08:53:18'),
(3, 9, '140 / 009 / SKCK / 2025', 'Surat Resmi Digital', '2025-11-28 10:03:34'),
(4, 12, '140 / 012 / NIKAH / 2025', 'Surat Resmi Digital', '2025-11-29 08:08:03'),
(5, 11, '140 / 011 / SKU / 2025', 'Surat Resmi Digital', '2025-11-29 12:47:06'),
(6, 13, '140 / 013 / SKU / 2025', 'Surat Resmi Digital', '2025-11-29 12:47:17'),
(7, 15, '140 / 015 / SKU / 2025', 'Surat Resmi Digital', '2025-11-29 15:28:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('admin','kades','masyarakat') NOT NULL,
  `nik` char(16) DEFAULT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `status_perkawinan` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `status_kependudukan` enum('Tetap','Pindah','Meninggal') DEFAULT 'Tetap',
  `status_akun` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `email`, `password`, `no_hp`, `alamat`, `jabatan`, `status_kependudukan`, `status_akun`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 'Admin ', NULL, NULL, NULL, NULL, NULL, NULL, 'admin@desa.id', '$2y$10$i59sFsL1uPRxfuqSUcyCpeTwcsTmwTeje2B/CInzhYRTj6W6W1vvO', '', '-', 'Kaur Tata Usaha', 'Tetap', 1, '2025-11-27 17:19:26', '2025-11-28 08:48:12'),
(2, 'kades', NULL, 'Yusnardi', NULL, NULL, NULL, NULL, NULL, NULL, 'kades@desa.id', '$2y$10$ibaowIueC3HPRpmkVHtLjeb52ZQ2Id5N.O9lNG3yzqFWRJqqkTJ4y', '', '-', 'Kepala Desa', 'Tetap', 1, '2025-11-27 17:19:26', '2025-11-29 15:31:49'),
(4, 'masyarakat', '1509071308050001', 'likhul', 'Wanareja', '2005-08-13', 'Laki-laki', 'Islam', 'Belum Kawin', 'Mahasiswa', 'likhul111@gmail.com', '$2y$10$2fAWaBgyhMVde2SEYks8WOmw8sJFA9LJeI1mAWX5vCcJih7o0eh6O', '', 'Serayu Ujung', NULL, 'Tetap', 1, '2025-11-27 17:40:20', '2025-11-29 09:14:37'),
(5, 'masyarakat', '1509071308050009', 'Solikhul Hadi', 'Wanaarum', '2025-11-03', 'Laki-laki', 'Islam', 'Belum Kawin', 'Mahasiswa', 'likhulhadi2@gmail.com', '$2y$10$HzvaeMSdRMbkcXl.bWT11uCF1wpXVTlz5f.MzCdEmcN/60bsYvROu', '082278934353', 'sungai duren', NULL, 'Tetap', 1, '2025-11-28 09:44:53', '2025-11-29 12:48:15'),
(6, 'masyarakat', '1509071308050003', 'Solikhul ', 'Wanaarum', '2025-10-31', 'Laki-laki', 'Islam', 'Belum Kawin', 'Pelajar', 'likhulhadi@gmail.com', '$2y$10$yYiGTQ420dA.sETHnxvx0uiX6FEExm/aZPjjFMY2veHmi4adl7qR6', '082278934353', 'Sungai Duren', NULL, 'Pindah', 1, '2025-11-29 08:13:33', '2025-11-29 12:51:08'),
(8, 'admin', NULL, 'Solikhul Hadi', NULL, NULL, NULL, NULL, NULL, NULL, 'likhulhadi0@gmail.com', '$2y$10$DqBYH9nIcAokvVif2Sx4yO/zK9s4WYvWp84UGg.lNfQhP5ad2cPpC', '082278934353', '-', 'Sekretaris Desa', 'Tetap', 1, '2025-11-29 12:25:01', '2025-11-29 12:25:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_id` (`permohonan_id`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_surat` (`kode_surat`);

--
-- Indeks untuk tabel `mutasi_penduduk`
--
ALTER TABLE `mutasi_penduduk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_tiket` (`nomor_tiket`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indeks untuk tabel `surat_digital`
--
ALTER TABLE `surat_digital`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_id` (`permohonan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `mutasi_penduduk`
--
ALTER TABLE `mutasi_penduduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `surat_digital`
--
ALTER TABLE `surat_digital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokumen_pendukung`
--
ALTER TABLE `dokumen_pendukung`
  ADD CONSTRAINT `dokumen_pendukung_ibfk_1` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD CONSTRAINT `informasi_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mutasi_penduduk`
--
ALTER TABLE `mutasi_penduduk`
  ADD CONSTRAINT `mutasi_penduduk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  ADD CONSTRAINT `permohonan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_ibfk_2` FOREIGN KEY (`layanan_id`) REFERENCES `jenis_layanan` (`id`);

--
-- Ketidakleluasaan untuk tabel `surat_digital`
--
ALTER TABLE `surat_digital`
  ADD CONSTRAINT `surat_digital_ibfk_1` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
