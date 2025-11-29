<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Cek Role User untuk menentukan layout
$role = $_SESSION['role'] ?? 'guest';
$nama = $_SESSION['nama'] ?? 'User';

// Tentukan siapa yang pakai Sidebar (Hanya Admin & Kades)
$useSidebar = in_array($role, ['admin', 'kades']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPMAS Desa</title>
    
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
</head>
<body class="<?= $useSidebar ? 'admin-mode' : '' ?>">

    <header>
        <div style="display: flex; align-items: center; gap: 15px;">
            <img src="assets/images/logo.png" alt="Logo" style="height: 40px; width: auto;" onerror="this.style.display='none'">
            <div>
                <h1 style="margin: 0; font-size: 1.1rem; line-height: 1.2;">SIPMAS</h1>
                <small style="opacity: 0.8; font-size: 0.8rem; font-weight: normal;">Desa Simpang Sungai Duren</small>
            </div>
        </div>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span id="user-info" style="color: rgba(255,255,255,0.9); font-size: 0.85rem; text-align: right;">
                    Halo, <strong><?= htmlspecialchars($nama); ?></strong><br>
                    <span style="font-size: 0.75rem; opacity: 0.7;">(<?= ucfirst($role) ?>)</span>
                </span>
                
                <?php if(!$useSidebar): // [POSISI 1] Logout untuk Warga (Header Atas) ?>
                    <a href="index.php?page=profil" style="color: white; text-decoration: none; font-size: 0.85rem; margin-right: 10px;">Profil</a>
                    
                    <a href="#" onclick="showPopup('logout', 'Konfirmasi Logout', 'Yakin ingin keluar dari sistem?', () => window.location.href='index.php?page=logout')" 
                       class="btn-warning" style="padding: 6px 15px; font-size: 0.8rem; border-radius: 20px; font-weight: bold;">
                       Logout
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </header>

    <main>
        
        <?php if ($useSidebar): ?>
        <div class="admin-layout">
            
            <aside class="admin-sidebar">
                <div class="sidebar-header">
                    <h4>Menu Utama</h4>
                    <p>Panel <?= ucfirst($role) ?></p>
                </div>
                
                <ul class="sidebar-menu">
                    <?php $p = $_GET['page'] ?? ''; ?>

                    <?php if($role == 'admin'): ?>
                        <li><a href="index.php?page=dashboard_admin" class="<?= $p=='dashboard_admin'?'active':'' ?>"><span>🏠</span> Dashboard</a></li>
                        <li><a href="index.php?page=manajemen_penduduk" class="<?= ($p=='manajemen_penduduk'||$p=='form_penduduk')?'active':'' ?>"><span>👥</span> Data Penduduk</a></li>
                        <li><a href="index.php?page=manajemen_staf" class="<?= ($p=='manajemen_staf'||$p=='form_staf')?'active':'' ?>"><span>👔</span> Data Staf</a></li>
                        <li><a href="index.php?page=kelola_layanan" class="<?= ($p=='kelola_layanan'||$p=='form_layanan')?'active':'' ?>"><span>⚙</span> Jenis Layanan</a></li>
                        <li><a href="index.php?page=kelola_info" class="<?= $p=='kelola_info'?'active':'' ?>"><span>📢</span> Info Desa</a></li>
                        <li><a href="index.php?page=admin_pengaduan" class="<?= $p=='admin_pengaduan'?'active':'' ?>"><span>💬</span> Pengaduan</a></li>
                        <li><a href="index.php?page=laporan" class="<?= ($p=='laporan'||$p=='cetak_laporan')?'active':'' ?>"><span>📊</span> Laporan</a></li>
                        <li><a href="index.php?page=data_mutasi" class="<?= $p=='data_mutasi'?'active':'' ?>"><span>🔄</span> Mutasi Warga</a></li>
                    
                    <?php elseif($role == 'kades'): ?>
                        <li><a href="index.php?page=dashboard_kades" class="<?= $p=='dashboard_kades'?'active':'' ?>"><span>🏠</span> Dashboard</a></li>
                        <li><a href="index.php?page=laporan" class="<?= ($p=='laporan'||$p=='cetak_laporan')?'active':'' ?>"><span>📊</span> Laporan & Arsip</a></li>
                        <li><a href="index.php?page=profil" class="<?= $p=='profil'?'active':'' ?>"><span>👤</span> Profil Saya</a></li>
                    <?php endif; ?>

                    <li>
                        <a href="#" onclick="showPopup('logout', 'Konfirmasi Logout', 'Yakin ingin keluar dari sistem?', () => window.location.href='index.php?page=logout')" 
                           style="color: var(--danger); border-top: 1px solid rgba(255,255,255,0.1); margin-top: 10px;">
                            <span>🚪</span> Logout
                        </a>
                    </li>
                </ul>
            </aside>

            <div class="admin-content">
                <?php if(isset($_SESSION['flash_message'])): ?>
                    <div class="alert badge-<?= $_SESSION['flash_type']=='success'?'success':'danger' ?>" 
                         style="display:block; padding: 15px; margin-bottom: 25px; border-radius: 8px; color: #fff; background-color: <?= $_SESSION['flash_type']=='success'?'#28a745':'#dc3545' ?>; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <?= $_SESSION['flash_message']; ?>
                    </div>
                    <?php unset($_SESSION['flash_message']); unset($_SESSION['flash_type']); ?>
                <?php endif; ?>

        <?php else: ?>
            <?php if(isset($_SESSION['flash_message'])): ?>
                <div class="card" style="background: <?= $_SESSION['flash_type']=='success'?'#d1e7dd':'#f8d7da' ?>; color: <?= $_SESSION['flash_type']=='success'?'#0f5132':'#842029' ?>; text-align:center; padding: 15px; margin-bottom: 20px; border: 1px solid <?= $_SESSION['flash_type']=='success'?'#badbcc':'#f5c6cb' ?>;">
                    <?= $_SESSION['flash_message']; ?>
                </div>
                <?php unset($_SESSION['flash_message']); unset($_SESSION['flash_type']); ?>
            <?php endif; ?>

        <?php endif; ?>