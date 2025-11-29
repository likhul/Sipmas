<section>
    <div class="content-header">
        <div>
            <h2 style="margin: 0; color: var(--primary);">📂 Gudang Arsip Digital</h2>
            <p style="margin: 5px 0 0; color: #666;">Daftar surat yang sudah selesai dan diarsipkan.</p>
        </div>
        <a href="index.php?page=dashboard_admin" class="btn-warning" style="text-decoration: none; border-radius: 5px; font-size: 0.9rem; padding: 8px 15px;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Reg / No. Surat</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Arsip</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarArsip)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                <div style="font-size: 2rem; margin-bottom: 10px;">📭</div>
                                <h4 style="margin: 0; color: #555;">Gudang arsip kosong</h4>
                                <p style="font-size: 0.9rem;">Belum ada surat yang diarsipkan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarArsip as $a): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--primary);">
                                        <?= $a->nomor_surat_resmi ?? $a->nomor_tiket ?>
                                    </strong>
                                </td>
                                <td><?= htmlspecialchars($a->nama_lengkap) ?></td>
                                <td><?= htmlspecialchars($a->nama_layanan) ?></td>
                                <td><?= date('d M Y', strtotime($a->updated_at)) ?></td>
                                <td style="text-align: center;">
                                    <a href="index.php?page=detail_permohonan&id=<?= $a->id ?>" 
                                       class="btn-primary" 
                                       style="padding: 6px 12px; font-size: 0.85rem; background: #6c757d; color: white;">
                                        👁 Lihat Data
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>