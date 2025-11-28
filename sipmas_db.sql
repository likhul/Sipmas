-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2025 pada 11.19
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
(1, 5, 'Surat-Resmi-.pdf', 'assets/uploads/DOC-3-1764264793.pdf', 'Lampiran Utama', '2025-11-27 17:33:13'),
(2, 6, 'Screenshot 2025-11-08 220929.png', 'assets/uploads/DOC-6-1764264971.png', 'Lampiran Utama', '2025-11-27 17:36:11'),
(3, 7, 'Screenshot 2025-11-08 220929.png', 'assets/uploads/DOC-7-1764268335.png', 'Lampiran Utama', '2025-11-27 18:32:15'),
(4, 8, 'Screenshot 2025-10-15 194152.png', 'assets/uploads/DOC-8-1764319391.png', 'Lampiran', '2025-11-28 08:43:11'),
(5, 9, 'Screenshot 2025-10-15 194807.png', 'assets/uploads/DOC-9-1764319509.png', 'Lampiran', '2025-11-28 08:45:09'),
(6, 10, 'Screenshot 2025-10-19 145913.png', 'assets/uploads/DOC-10-1764319609.png', 'Lampiran', '2025-11-28 08:46:49'),
(7, 11, 'Screenshot 2025-10-19 145913.png', 'assets/uploads/DOC-11-1764320379.png', 'Lampiran', '2025-11-28 08:59:39');

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
(1, 'Jadwal Pelayanan Kantor Desa', 'Pengumuman', 'Pelayanan kantor desa buka setiap hari Senin - Jumat pukul 08.00 - 16.00 WIB.', '2025-11-28 00:19:26', 1),
(2, 'Kerja Bakti Minggu Ini', 'Jadwal', 'Diharapkan kehadiran warga RT 01 dan 02 untuk kerja bakti membersihkan selokan pada hari Minggu.', '2025-11-28 00:19:26', 1),
(3, 'gotong royong', 'Jadwal', 'kerjaa', '2025-11-28 00:49:54', 1);

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
(4, 'Surat Keterangan Tidak Mampu (SKTM)', 'SKTM', '[\"KTP\", \"KK\", \"Surat Pengantar RT\"]', 1),
(5, 'Surat Keterangan Kelahiran', 'LHR', '[\"KTP Orang Tua\", \"KK\", \"Surat Bidan/RS\"]', 1),
(6, 'Surat Keterangan Kematian', 'KMT', '[\"KTP Almarhum\", \"KK\", \"Surat Pengantar RT\"]', 1),
(7, 'Surat Pengantar Nikah (N1-N4)', 'NIKAH', '[\"KTP\", \"KK\", \"Akte Kelahiran\", \"Ijazah Terakhir\", \"Pas Foto 2x3\"]', 1),
(8, 'Surat Izin Keramaian', 'IZIN', '[\"KTP Penanggung Jawab\", \"Surat Pernyataan\", \"Jadwal Acara\"]', 1);

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
(1, 3, 'Masuk', '2025-10-29', 'kerja', '2025-11-27 18:38:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subjek` varchar(150) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `status` enum('Terkiim','Dibaca','Selesai') DEFAULT 'Terkiim',
  `tanggapan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `subjek`, `isi_pengaduan`, `status`, `tanggapan_admin`, `created_at`) VALUES
(1, 3, 'jalan rusak', 'disini', 'Terkiim', NULL, '2025-11-27 18:21:37'),
(2, 4, 'Jalan Rusak disini', 'secepatnya pak', 'Terkiim', NULL, '2025-11-28 08:44:14'),
(3, 4, 'Jalan Rusak disini', 'asfgh', 'Terkiim', NULL, '2025-11-28 09:00:30');

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
(5, 3, 1, 'TIKET-20251127-5162', '{\"keperluan\":\"kerja\",\"keterangan\":\"aa\"}', 'ditolak', NULL, NULL, 1, 'kamu bohong', 0, '2025-11-27 17:33:13', '2025-11-27 17:38:54'),
(6, 3, 3, 'TIKET-20251127-2177', '{\"keperluan\":\"kerja\",\"keterangan\":\"aa\"}', 'disetujui', 1, 2, NULL, NULL, 1, '2025-11-27 17:36:11', '2025-11-28 08:37:53'),
(7, 3, 2, 'TIKET-20251127-6465', '{\"keperluan\":\"a\",\"keterangan\":\"a\"}', 'ditolak', NULL, NULL, 1, 'tidur', 0, '2025-11-27 18:32:15', '2025-11-27 18:39:20'),
(8, 4, 1, 'TIKET-20251128-4352', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-28 08:43:11', '2025-11-28 08:53:15'),
(9, 4, 3, 'TIKET-20251128-1506', '{\"keperluan\":\"untuk membuat skck\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-28 08:45:09', '2025-11-28 10:03:34'),
(10, 4, 2, 'TIKET-20251128-3845', '{\"keperluan\":\"PIndah Alamat\",\"keterangan\":\"\"}', 'disetujui', 1, 2, NULL, NULL, 0, '2025-11-28 08:46:49', '2025-11-28 08:53:18'),
(11, 4, 1, 'TIKET-20251128-5667', '{\"keperluan\":\"untuk membuka usaha\",\"keterangan\":\"\"}', 'menunggu_kades', 1, NULL, NULL, NULL, 0, '2025-11-28 08:59:39', '2025-11-28 10:06:13');

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
(3, 9, '140 / 009 / SKCK / 2025', 'Surat Resmi Digital', '2025-11-28 10:03:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('admin','kades','masyarakat') NOT NULL,
  `nik` char(16) DEFAULT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
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

INSERT INTO `users` (`id`, `role`, `nik`, `nama_lengkap`, `email`, `password`, `no_hp`, `alamat`, `jabatan`, `status_kependudukan`, `status_akun`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 'Admin ', 'admin@desa.id', '$2y$10$i59sFsL1uPRxfuqSUcyCpeTwcsTmwTeje2B/CInzhYRTj6W6W1vvO', '', '-', 'Kaur Tata Usaha', 'Tetap', 1, '2025-11-27 17:19:26', '2025-11-28 08:48:12'),
(2, 'kades', NULL, 'Bapak Kepala Desa', 'kades@desa.id', '$2y$10$ibaowIueC3HPRpmkVHtLjeb52ZQ2Id5N.O9lNG3yzqFWRJqqkTJ4y', '', '-', 'Kepala Desa', 'Tetap', 1, '2025-11-27 17:19:26', '2025-11-27 18:34:45'),
(3, 'masyarakat', '1571000000000001', 'Budi Warga', 'warga@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'suren', NULL, 'Tetap', 1, '2025-11-27 17:19:26', '2025-11-27 18:38:55'),
(4, 'masyarakat', '1509071308050001', 'likhul', 'likhul@gmail.com', '$2y$10$2fAWaBgyhMVde2SEYks8WOmw8sJFA9LJeI1mAWX5vCcJih7o0eh6O', '', 'serayu', NULL, 'Tetap', 1, '2025-11-27 17:40:20', '2025-11-27 17:40:20'),
(5, 'masyarakat', '1509071308050009', 'Solikhul Hadi', 'likhulhadi2@gmail.com', '$2y$10$AQuszOzxI03BYCbt7xdjlev/Kz6z3ZFDOhXHvQt.3xvaXLWBqTKXK', '', 'sungai duren', NULL, 'Tetap', 1, '2025-11-28 09:44:53', '2025-11-28 09:47:05');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `mutasi_penduduk`
--
ALTER TABLE `mutasi_penduduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `surat_digital`
--
ALTER TABLE `surat_digital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
