<?php
$isEdit = isset($infoEdit);
$formAction = $isEdit ? 'index.php?action=update_info' : 'index.php?action=simpan_info';
$formTitle = $isEdit ? 'Edit Pengumuman' : 'Buat Pengumuman Baru';
$btnText = $isEdit ? 'Simpan Perubahan' : 'Publikasikan';
?>

<section id="kelola-info">
    <div style="margin-bottom: 15px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold; font-size: 14px;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <h2>Manajemen Informasi & Pengumuman</h2>
    
    <div class="card" style="margin-bottom: 30px; border-left: 5px solid <?= $isEdit ? '#ffaa33' : '#1a2a47' ?>;">
        <h3 style="margin-top:0;"><?= $formTitle ?></h3>
        
        <form action="<?= $formAction ?>" method="POST">
            
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $infoEdit->id ?>">
            <?php endif; ?>

            <label>Judul:</label>
            <input type="text" name="judul" required value="<?= $isEdit ? $infoEdit->judul : '' ?>" 
                   placeholder="Contoh: Jadwal Posyandu..." style="width: 100%;">
            
            <label>Kategori:</label>
            <select name="kategori" required style="width: 100%;">
                <option value="Pengumuman" <?= ($isEdit && $infoEdit->kategori == 'Pengumuman') ? 'selected' : '' ?>>Pengumuman</option>
                <option value="Berita" <?= ($isEdit && $infoEdit->kategori == 'Berita') ? 'selected' : '' ?>>Berita</option>
                <option value="Jadwal" <?= ($isEdit && $infoEdit->kategori == 'Jadwal') ? 'selected' : '' ?>>Jadwal Kegiatan</option>
            </select>
            
            <label>Isi Konten:</label>
            <textarea name="isi" rows="4" required style="width: 100%;"><?= $isEdit ? $infoEdit->isi_konten : '' ?></textarea>
            
            <div style="margin-top: 15px;">
                <button type="submit" class="btn-primary" style="background: <?= $isEdit ? '#ffaa33' : '#1a2a47' ?>; color: <?= $isEdit ? '#1a2a47' : 'white' ?>;">
                    <?= $btnText ?>
                </button>

                <?php if($isEdit): ?>
                    <a href="index.php?page=kelola_info" class="btn-danger" style="text-decoration:none; background: #6c757d; margin-left: 10px;">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h3>Daftar Informasi Aktif</h3>
    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center">Tanggal</th>
                        <th style="text-align: center">Kategori</th>
                        <th style="text-align: center">Judul</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($daftarInfo)): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 20px;">Belum ada informasi.</td></tr>
                    <?php else: ?>
                        <?php foreach($daftarInfo as $info): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($info->tanggal_posting)) ?></td>
                            <td>
                                <span class="badge badge-warning"><?= $info->kategori ?></span>
                            </td>
                            <td><?= htmlspecialchars($info->judul) ?></td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <a href="index.php?page=kelola_info&id=<?= $info->id ?>" class="btn-action btn-edit" style="min-width: auto;">
                                       ✏️ Edit
                                    </a>

                                    <a href="#" 
                                        onclick="showPopup('delete', 'Hapus Info?', 'Pengumuman ini akan dihapus dari dashboard warga.', () => window.location.href='index.php?action=hapus_info&id=<?= $info->id ?>')" 
                                        class="btn-action btn-delete" style="min-width: auto;">
                                            🗑️ Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>