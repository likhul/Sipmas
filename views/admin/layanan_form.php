<?php
$isEdit = isset($layananEdit);
$action = $isEdit ? 'update_layanan' : 'simpan_layanan';
$title = $isEdit ? 'Edit Jenis Layanan' : 'Tambah Jenis Layanan Baru';
?>

<section>
    <div style="max-width: 600px; margin: 0 auto;">
        <h2><?= $title ?></h2>
        <div class="card">
            <form action="index.php?action=<?= $action ?>" method="POST">
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $layananEdit->id ?>">
                <?php endif; ?>

                <label>Nama Layanan Surat:</label>
                <input type="text" name="nama" required placeholder="Contoh: Surat Keterangan Usaha" 
                       value="<?= $isEdit ? $layananEdit->nama_layanan : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Kode Surat (Untuk Penomoran):</label>
                <input type="text" name="kode" required placeholder="Contoh: SKU" 
                       value="<?= $isEdit ? $layananEdit->kode_surat : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Persyaratan Dokumen (Pisahkan dengan koma):</label>
                <textarea name="syarat" rows="3" required placeholder='Contoh: ["KTP", "KK", "Foto Usaha"]' 
                          style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;"><?= $isEdit ? $layananEdit->syarat_dokumen : '' ?></textarea>
                <small style="display:block; margin-top:-15px; margin-bottom:20px; color:#666;">Format JSON sederhana array string.</small>

                <div style="text-align: right;">
                    <a href="index.php?page=kelola_layanan" style="margin-right: 15px; text-decoration: none; color: #666;">Batal</a>
                    <button type="submit" style="background: var(--primary-color); color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>