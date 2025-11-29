<section id="admin-pengaduan">
    <div style="margin-bottom: 15px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold; font-size: 14px;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <h2>Daftar Pengaduan & Aspirasi Warga</h2>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 20%;">Pengirim</th>
                        <th style="width: 20%;">Subjek</th>
                        <th style="width: 30%;">Isi Pengaduan</th>
                        <th style="width: 15%;">Status & Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPengaduan)): ?>
                        <tr><td colspan="5" style="text-align: center; padding: 20px; color: #888;">Belum ada pengaduan masuk.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarPengaduan as $p): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($p->created_at)) ?></td>
                                <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                <td><?= htmlspecialchars($p->subjek) ?></td>
                                <td>
                                    <p style="margin: 0; font-size: 13px; color: #555;">
                                        <?= nl2br(htmlspecialchars($p->isi_pengaduan)) ?>
                                    </p>
                                </td>
                                <td>
                                    <form action="index.php?action=update_status_pengaduan" method="POST">
                                        <input type="hidden" name="id" value="<?= $p->id ?>">
                                        <select name="status" onchange="this.form.submit()" 
                                                style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; 
                                                       background: <?= $p->status=='Selesai'?'#d4edda':'#fff3cd' ?>">
                                            <option value="Terkirim" <?= $p->status=='Terkirim'?'selected':'' ?>>Terkirim</option>
                                            <option value="Dibaca" <?= $p->status=='Dibaca'?'selected':'' ?>>Dibaca</option>
                                            <option value="Selesai" <?= $p->status=='Selesai'?'selected':'' ?>>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>