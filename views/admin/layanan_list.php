<section id="kelola-layanan">
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Kelola Jenis Layanan Surat</h2>
        <a href="index.php?page=form_layanan" class="btn-primary" style="background: var(--primary-color); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            + Tambah Jenis Surat
        </a>
    </div>

    <div class="card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #ddd;">
                    <th style="padding: 12px; text-align: left;">Kode</th>
                    <th style="padding: 12px; text-align: left;">Nama Layanan</th>
                    <th style="padding: 12px; text-align: left;">Syarat Dokumen</th>
                    <th style="padding: 12px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($daftarLayanan)): ?>
                    <tr><td colspan="4" style="text-align:center; padding: 20px;">Belum ada jenis layanan.</td></tr>
                <?php else: ?>
                    <?php foreach($daftarLayanan as $l): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><strong><?= $l->kode_surat ?></strong></td>
                        <td style="padding: 10px;"><?= $l->nama_layanan ?></td>
                        <td style="padding: 10px; font-size: 13px; color: #666;">
                            <?= $l->syarat_dokumen ?>
                        </td>
                        <td style="padding: 10px; text-align: center;">
                            <a href="index.php?page=form_layanan&id=<?= $l->id ?>" 
                               style="color: #e0a800; text-decoration: none; font-weight: bold; margin-right: 10px;">Edit</a>
                            
                            <a href="index.php?action=hapus_layanan&id=<?= $l->id ?>" 
                               onclick="return confirm('Hapus layanan ini?')"
                               style="color: #dc3545; text-decoration: none; font-weight: bold;">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>