<section id="manajemen-staf">
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Manajemen Akun Internal (Admin & Kades)</h2>
        <a href="index.php?page=form_staf" class="btn-primary" style="background: var(--primary-color); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            + Tambah Pegawai Baru
        </a>
    </div>
    
    <div class="card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding:10px; border-bottom:2px solid #ddd;">Nama</th>
                    <th style="padding:10px; border-bottom:2px solid #ddd;">Email</th>
                    <th style="padding:10px; border-bottom:2px solid #ddd;">Role</th>
                    <th style="padding:10px; border-bottom:2px solid #ddd;">Jabatan</th>
                    <th style="padding:10px; border-bottom:2px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($daftarStaf)): ?>
                    <tr><td colspan="5" style="text-align:center; padding:20px;">Belum ada data staf.</td></tr>
                <?php else: ?>
                    <?php foreach($daftarStaf as $u): ?>
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <?= htmlspecialchars($u->nama_lengkap) ?>
                            </td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <?= htmlspecialchars($u->email) ?>
                            </td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <span class="badge" style="background: <?= $u->role=='admin'?'#17a2b8':'#6f42c1' ?>; color:white; padding:3px 8px; border-radius:4px; font-size:12px;">
                                    <?= htmlspecialchars(strtoupper($u->role)) ?>
                                </span>
                            </td>       
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <?= htmlspecialchars($u->jabatan ?? '-') ?>
                            </td>
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <a href="index.php?page=form_staf&id=<?= $u->id ?>" style="color: #e0a800; font-weight:bold; text-decoration:none;">Edit</a>|
                                <a href="index.php?action=hapus_staf&id=<?= $u->id ?>" onclick="return confirm('Hapus akun ini?')" style="color: #dc3545; font-weight:bold; text-decoration:none;">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>