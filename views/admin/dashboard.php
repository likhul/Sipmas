<section>
    <div class="content-header">
        <div>
            <h2 style="margin: 0; color: var(--primary);">Dashboard Overview</h2>
            <p style="margin: 5px 0 0; color: #666;">Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong></p>
        </div>
        <div style="text-align: right;">
            <span class="badge badge-warning" style="font-size: 0.9rem; padding: 10px 15px;">
                <?= count($permohonanMasuk) ?> Perlu Verifikasi
            </span>
        </div>
    </div>

    <div class="card">
        <h3>Verifikasi Permohonan Masuk</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Pemohon</th> <th>Jenis Surat</th> <th>Status</th> <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($permohonanMasuk)): ?>
                        <tr><td colspan="4" style="text-align:center; padding: 30px; color: #888;">Tidak ada permohonan baru.</td></tr>
                    <?php else: ?>
                        <?php foreach ($permohonanMasuk as $p): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($p->nama_pemohon) ?></strong><br>
                                    <small style="color:#666;">Tiket: <?= $p->nomor_tiket ?></small>
                                </td>
                                <td><?= htmlspecialchars($p->nama_layanan) ?></td>
                                <td><span class="badge badge-warning">Menunggu Verifikasi</span></td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 5px; justify-content: center; align-items: center;">
                                        <a href="index.php?page=detail_permohonan&id=<?= $p->id ?>" class="btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">👁 Detail</a>
                                        
                                        <form action="index.php?action=verifikasi_admin" method="POST" style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $p->id ?>">
                                            <input type="hidden" name="keputusan" value="terima">
                                            <button type="submit" class="btn-warning" style="padding: 6px 12px; font-size: 0.85rem; border: 1px solid;">✔ Teruskan</button>
                                        </form>

                                        <button type="button" onclick="bukaModalTolak(<?= $p->id ?>)" class="btn-danger" style="padding: 6px 12px; font-size: 0.85rem;">✖ Tolak</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top: 30px;">
        <h3>Surat Disetujui</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Registrasi</th> <th>Pemohon</th> <th>Jenis Surat</th> <th>Disetujui Tanggal</th> <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($permohonanSiapCetak)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                <div style="font-size: 2rem; margin-bottom: 10px;">📭</div>
                                <h4 style="margin: 0; color: #555;">Belum ada data</h4>
                                <p style="font-size: 0.9rem; margin:0;">Saat ini belum ada surat yang selesai diproses.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($permohonanSiapCetak as $pc): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--primary);">
                                        <?= $pc->nomor_surat_resmi ?? $pc->nomor_tiket ?>
                                    </strong>
                                </td>
                                <td><?= htmlspecialchars($pc->nama_pemohon) ?></td>
                                <td><?= htmlspecialchars($pc->nama_layanan) ?></td>
                                <td><?= date('d M Y', strtotime($pc->updated_at)) ?></td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                        <a href="index.php?page=cetak_surat&id=<?= $pc->id ?>" target="_blank" 
                                           class="btn-success" 
                                           style="padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; color: white; display: inline-flex; align-items: center;">
                                            🖨 Cetak
                                        </a>
                                        
                                        <a href="#" 
                                           onclick="showPopup('confirm', 'Arsipkan Surat?', 'Surat akan dipindahkan ke Gudang Arsip.', () => window.location.href='index.php?action=arsipkan_surat&id=<?= $pc->id ?>')"
                                           class="btn-primary"
                                           style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center;">
                                            📦 Arsip
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: right; margin-top: 15px; border-top: 1px solid #f0f0f0; padding-top: 10px;">
            <a href="index.php?page=data_arsip" style="font-size: 0.85rem; color: #6c757d; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 5px;">
                📂 Buka Gudang Arsip &rarr;
            </a>
        </div>
    </div>
</section>

<script>
function bukaModalTolak(idPermohonan) {
    // Menggunakan sistem Global Modal (showPopup) yang ada di footer
    showPopup('input', 'Tolak Permohonan', 'Silakan tulis alasan penolakan agar warga mengerti.', function(alasan) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?action=verifikasi_admin';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden'; inputId.name = 'id'; inputId.value = idPermohonan;
        
        const inputKeputusan = document.createElement('input');
        inputKeputusan.type = 'hidden'; inputKeputusan.name = 'keputusan'; inputKeputusan.value = 'tolak';
        
        const inputAlasan = document.createElement('input');
        inputAlasan.type = 'hidden'; inputAlasan.name = 'alasan'; inputAlasan.value = alasan;

        form.appendChild(inputId); form.appendChild(inputKeputusan); form.appendChild(inputAlasan);
        document.body.appendChild(form);
        form.submit();
    });
}
</script>