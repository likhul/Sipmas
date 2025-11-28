<section id="admin-pengaduan">
    <div style="margin-bottom: 15px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold; font-size: 14px;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <h2>Daftar Pengaduan & Aspirasi Warga</h2>

    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 20%;">Pengirim</th>
                        <th style="width: 20%;">Subjek</th>
                        <th style="width: 35%;">Isi Pengaduan</th>
                        <th style="width: 10%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPengaduan)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                                Belum ada pengaduan masuk.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPengaduan as $p): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($p->created_at)) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($p->nama_lengkap) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($p->subjek) ?></td>
                                <td>
                                    <p style="margin: 0; font-size: 13px; color: #555;">
                                        <?= nl2br(htmlspecialchars($p->isi_pengaduan)) ?>
                                    </p>
                                </td>
                                <td>
                                    <span class="badge" style="background: #17a2b8; color: white;">
                                        <?= $p->status ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>