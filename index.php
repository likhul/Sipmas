<?php
// =================================================================================
// ROUTER UTAMA (Main Controller) - FINAL COMPLETE EDITION V5 (MASTER)
// Mengatur: Login, Surat, Penduduk (Search & Mutasi), Info, Layanan, Staf, Pengaduan, Laporan
// =================================================================================

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Load Configurations & Controllers
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PermohonanController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/InfoController.php';
require_once 'controllers/LayananController.php';

// 2. Initialize Instances
$database = new Database();
$db = $database->getConnection();

$authController = new AuthController($db);
$permohonanController = new PermohonanController($db);
$userController = new UserController($db);
$infoController = new InfoController($db);
$layananController = new LayananController($db);

// 3. Capture Request
$page = isset($_GET['page']) ? $_GET['page'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : null;


// =================================================================================
// A. HANDLE POST REQUEST (SEMUA PROSES PENYIMPANAN DATA)
// =================================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- AUTH (LOGIN & REGISTER) ---
    if ($action == 'login_process') {
        $email = $_POST['email']; $password = $_POST['password'];
        if ($authController->login($email, $password)) {
            $dest = ($_SESSION['role']=='admin')?'dashboard_admin':(($_SESSION['role']=='kades')?'dashboard_kades':'dashboard_warga');
            header("Location: index.php?page=$dest"); exit();
        } else {
            $_SESSION['flash_message'] = "Login Gagal! Cek kredensial.";
            $_SESSION['flash_type'] = "error";
            header("Location: index.php?page=auth"); exit();
        }
    }

    if ($action == 'register_process') {
        $res = $authController->register($_POST['nik'], $_POST['nama_lengkap'], $_POST['email'], $_POST['password'], $_POST['alamat']);
        if ($res === true) {
            $_SESSION['flash_message'] = "Berhasil Daftar! Silakan Login.";
            $_SESSION['flash_type'] = "success";
            header("Location: index.php?page=auth");
        } else {
            $_SESSION['flash_message'] = $res;
            $_SESSION['flash_type'] = "error";
            header("Location: index.php?page=auth&mode=register");
        }
        exit();
    }

    // --- PROFIL SAYA ---
    if ($action == 'update_profil') {
        if(!isset($_SESSION['user_id'])) die("Akses Ditolak");
        $res = $userController->updateProfile($_SESSION['user_id'], $_POST['nama'], $_POST['email'], $_POST['hp'], $_POST['alamat'], $_POST['password']);
        $_SESSION['flash_message'] = ($res===true) ? "Profil diperbarui" : $res;
        $_SESSION['flash_type'] = ($res===true) ? "success" : "error";
        header("Location: index.php?page=profil"); exit();
    }

    // --- MASTER LAYANAN (SIA-03) ---
    if ($action == 'simpan_layanan') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $res = $layananController->createLayanan($_POST['nama'], $_POST['kode'], $_POST['syarat']);
        header("Location: index.php?page=kelola_layanan"); exit();
    }
    if ($action == 'update_layanan') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $layananController->updateLayanan($_POST['id'], $_POST['nama'], $_POST['kode'], $_POST['syarat']);
        header("Location: index.php?page=kelola_layanan"); exit();
    }

    // --- TRANSAKSI SURAT (SIA-11, SIA-06, SIA-07) ---
    if ($action == 'simpan_permohonan') {
        $res = $permohonanController->ajukanSurat($_SESSION['user_id'], $_POST['jenis_surat'], ['keperluan'=>$_POST['keperluan'], 'keterangan'=>$_POST['keterangan_tambahan']], $_FILES['dokumen_pendukung']);
        $_SESSION['flash_message'] = $res ? "Permohonan terkirim!" : "Gagal kirim permohonan. Cek file.";
        $_SESSION['flash_type'] = $res ? "success" : "error";
        header("Location: index.php?page=riwayat_permohonan"); exit();
    }
    if ($action == 'verifikasi_admin') {
        $permohonanController->prosesVerifikasiAdmin($_POST['id'], $_SESSION['user_id'], $_POST['keputusan'], $_POST['alasan'] ?? null);
        $_SESSION['flash_message'] = "Verifikasi diproses.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=dashboard_admin"); exit();
    }
    if ($action == 'approval_kades') {
        $permohonanController->approvalKades($_POST['id'], $_SESSION['user_id']);
        $_SESSION['flash_message'] = "Surat disetujui.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=dashboard_kades"); exit();
    }

    // --- DATA PENDUDUK & MUTASI (SIA-02) ---
    if ($action == 'simpan_penduduk') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $data = ['role' => 'masyarakat', 'nik' => $_POST['nik'], 'nama' => $_POST['nama'], 'email' => $_POST['email'], 'password' => $_POST['password'], 'alamat' => $_POST['alamat'], 'hp' => $_POST['hp']];
        $res = $userController->createUser($data);
        $_SESSION['flash_message'] = ($res===true) ? "Penduduk ditambahkan" : $res;
        $_SESSION['flash_type'] = ($res===true) ? "success" : "error";
        header("Location: index.php?page=manajemen_penduduk"); exit();
    }
    if ($action == 'update_penduduk') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $data = ['id' => $_POST['id'], 'nik' => $_POST['nik'], 'nama' => $_POST['nama'], 'email' => $_POST['email'], 'password' => $_POST['password'], 'alamat' => $_POST['alamat'], 'hp' => $_POST['hp'], 'status_kependudukan' => $_POST['status_kependudukan']];
        $userController->updateUser($data);
        $_SESSION['flash_message'] = "Data penduduk diperbarui";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=manajemen_penduduk"); exit();
    }
    // MUTASI
    if ($action == 'simpan_mutasi') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $res = $userController->catatMutasi($_POST['user_id'], $_POST['jenis_mutasi'], $_POST['tanggal'], $_POST['keterangan']);
        $_SESSION['flash_message'] = $res ? "Mutasi dicatat." : "Gagal catat mutasi.";
        $_SESSION['flash_type'] = $res ? "success" : "error";
        header("Location: index.php?page=data_mutasi"); exit();
    }

    // --- MANAJEMEN STAF (ADMIN & KADES) ---
    if ($action == 'simpan_staf') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $data = ['role'=>$_POST['role'], 'nik'=>null, 'nama'=>$_POST['nama'], 'email'=>$_POST['email'], 'password'=>$_POST['password'], 'alamat'=>'-', 'hp'=>$_POST['hp'], 'jabatan'=>$_POST['jabatan']];
        $userController->createUser($data);
        header("Location: index.php?page=manajemen_staf"); exit();
    }
    if ($action == 'update_staf') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $data = ['id'=>$_POST['id'], 'nama'=>$_POST['nama'], 'email'=>$_POST['email'], 'password'=>$_POST['password'], 'alamat'=>'-', 'hp'=>$_POST['hp'], 'jabatan'=>$_POST['jabatan']];
        $userController->updateUser($data);
        header("Location: index.php?page=manajemen_staf"); exit();
    }

    // --- INFO & PENGADUAN ---
    if ($action == 'simpan_info') {
        $infoController->createInfo($_POST['judul'], $_POST['kategori'], $_POST['isi'], $_SESSION['user_id']);
        $_SESSION['flash_message'] = "Pengumuman diterbitkan.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=kelola_info"); exit();
    }
    if ($action == 'update_info') {
        if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
        $infoController->updateInfo($_POST['id'], $_POST['judul'], $_POST['kategori'], $_POST['isi']);
        $_SESSION['flash_message'] = "Pengumuman berhasil diperbarui.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=kelola_info"); exit();
    }
    if ($action == 'kirim_pengaduan') {
        if (!isset($_SESSION['user_id'])) die("Akses Ditolak");
        $userController->simpanPengaduan($_SESSION['user_id'], $_POST['subjek'], $_POST['isi']);
        $_SESSION['flash_message'] = "Pengaduan terkirim.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php?page=pengaduan_saya"); exit();
    }
}

// =================================================================================
// B. HANDLE GET REQUEST (DELETE ACTIONS)
// =================================================================================
if ($action == 'hapus_layanan') { $layananController->deleteLayanan($_GET['id']); header("Location: index.php?page=kelola_layanan"); exit(); }
if ($action == 'hapus_penduduk') { $userController->deletePenduduk($_GET['id']); header("Location: index.php?page=manajemen_penduduk"); exit(); }
if ($action == 'hapus_info') { $infoController->deleteInfo($_GET['id']); header("Location: index.php?page=kelola_info"); exit(); }
if ($action == 'hapus_staf') { 
    if($_GET['id'] == $_SESSION['user_id']) { $_SESSION['flash_message']="Gagal hapus diri sendiri"; $_SESSION['flash_type']="error"; }
    else { $userController->deleteUser($_GET['id']); }
    header("Location: index.php?page=manajemen_staf"); exit();
}
if ($action == 'arsipkan_surat') { // ARSIP
    if ($_SESSION['role'] != 'admin') die("Akses Ditolak");
    $permohonanController->arsipkanSurat($_GET['id']);
    $_SESSION['flash_message'] = "Surat diarsipkan.";
    $_SESSION['flash_type'] = "success";
    header("Location: index.php?page=dashboard_admin"); exit();
}


// =================================================================================
// C. HANDLE GET REQUEST (TAMPILAN HALAMAN / VIEW)
// =================================================================================

// [FIX] JANGAN TAMPILKAN HEADER JIKA SEDANG CETAK
// Ini yang bikin tampilan print jadi bersih!
if ($page != 'cetak_surat' && $page != 'cetak_laporan') {
    require_once 'views/layouts/header.php';
}

switch ($page) {
    case 'auth':
        if(isset($_SESSION['user_id'])) {
             $dest = ($_SESSION['role']=='admin')?'dashboard_admin':(($_SESSION['role']=='kades')?'dashboard_kades':'dashboard_warga');
             header("Location: index.php?page=$dest"); exit();
        }
        include 'views/auth/login.php';
        break;

    // --- COMMON ---
    case 'profil':
        if(!isset($_SESSION['user_id'])) die("Login required");
        $user = $userController->getUserById($_SESSION['user_id']);
        include 'views/auth/profil.php';
        break;

    // --- MASYARAKAT ---
    case 'dashboard_warga':
        $daftarInfo = $infoController->getAllInfo();
        $riwayat = $permohonanController->getRiwayatUser($_SESSION['user_id']);
        include 'views/masyarakat/dashboard.php';
        break;
    case 'ajukan_surat':
        $daftarLayanan = $permohonanController->getDaftarLayanan();
        include 'views/masyarakat/ajukan.php';
        break;
    case 'riwayat_permohonan':
        $riwayat = $permohonanController->getRiwayatUser($_SESSION['user_id']);
        include 'views/masyarakat/riwayat.php';
        break;
    case 'pengaduan_saya':
        $daftarPengaduan = $userController->getPengaduanUser($_SESSION['user_id']);
        include 'views/masyarakat/pengaduan.php';
        break;

    // --- ADMIN ---
    case 'dashboard_admin':
        $permohonanMasuk = $permohonanController->getPermohonanByStatus('pending');
        $permohonanSiapCetak = $permohonanController->getPermohonanByStatus('disetujui');
        include 'views/admin/dashboard.php';
        break;
    
    // Fitur Admin Lainnya
    case 'kelola_layanan': $daftarLayanan = $layananController->getAllLayanan(); include 'views/admin/layanan_list.php'; break;
    case 'form_layanan': if(isset($_GET['id'])) $layananEdit = $layananController->getLayananById($_GET['id']); include 'views/admin/layanan_form.php'; break;
    case 'manajemen_penduduk': $keyword = $_GET['cari']??null; $daftarPenduduk = $userController->getAllMasyarakat($keyword); include 'views/admin/penduduk_list.php'; break;
    case 'form_penduduk': if(isset($_GET['id'])) $pendudukEdit = $userController->getUserById($_GET['id']); include 'views/admin/penduduk_form.php'; break;
    case 'manajemen_staf': $daftarStaf = $userController->getUsersByRole('internal'); include 'views/admin/staf_list.php'; break;
    case 'form_staf': if(isset($_GET['id'])) $stafEdit = $userController->getUserById($_GET['id']); include 'views/admin/staf_form.php'; break;
    case 'admin_pengaduan': $daftarPengaduan = $userController->getAllPengaduan(); include 'views/admin/pengaduan_list.php'; break;
    case 'data_mutasi': $daftarMutasi = $userController->getRiwayatMutasi(); $semuaWarga = $userController->getAllMasyarakat(); include 'views/admin/mutasi_list.php'; break;
    case 'data_arsip': $daftarArsip = $permohonanController->getArsip(); include 'views/admin/arsip_list.php'; break;

    case 'kelola_info':
        $daftarInfo = $infoController->getAllInfo();
        if (isset($_GET['id'])) {
            $infoEdit = $infoController->getInfoById($_GET['id']);
        }
        include 'views/admin/info_list.php';
        break;
    // --- KADES ---
    case 'dashboard_kades':
        $permohonanKades = $permohonanController->getPermohonanByStatus('menunggu_kades');
        include 'views/kades/dashboard.php';
        break;

    // --- UTILS (DETAIL, CETAK, LAPORAN) ---
    case 'detail_permohonan':
        $detail = $permohonanController->getDetailPermohonan($_GET['id']);
        include 'views/admin/detail.php';
        break;
    case 'cetak_surat':
        $detail = $permohonanController->getDetailPermohonan($_GET['id']);
        // Security check
        if(!isset($_SESSION['user_id'])) die("Login required");
        if($_SESSION['role']=='masyarakat' && $detail->user_id != $_SESSION['user_id']) die("Akses Ditolak");
        if(!in_array($detail->status, ['disetujui','selesai'])) die("Belum disetujui");
        include 'views/admin/cetak_surat.php';
        break;
    case 'laporan': include 'views/admin/laporan_filter.php'; break;
    case 'cetak_laporan': 
        $dataLaporan = $permohonanController->getLaporan($_GET['tgl_awal'], $_GET['tgl_akhir'], $_GET['status_filter']??null);
        include 'views/admin/laporan_cetak.php'; 
        break;

    case 'logout': session_destroy(); header("Location: index.php"); exit();
    default: echo "<h2 style='text-align:center;margin-top:50px;'>404 Not Found</h2>"; break;
}

// [FIX] JANGAN TAMPILKAN FOOTER JIKA SEDANG CETAK
if ($page != 'cetak_surat' && $page != 'cetak_laporan') {
    require_once 'views/layouts/footer.php';
}
?>