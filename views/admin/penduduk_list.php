<section id="manajemen-penduduk">
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666; font-weight: bold;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Manajemen Data Penduduk</h2>
        <a href="index.php?page=form_penduduk" class="btn-primary" style="background: var(--primary-color); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            + Tambah Penduduk
        </a>
    </div>

    <div class="card" style="padding: 15px; margin-bottom: 20px; background: #e9ecef;">
        <form action="index.php" method="GET" style="display: flex; gap: 10px; margin: 0;">
            <input type="hidden" name="page" value="manajemen_penduduk">
            <input type="text" name="cari" placeholder="Cari NIK atau Nama..." value="<?= $_GET['cari'] ?? '' ?>" style="flex: 1; margin: 0; padding: 10px;">
            <button type="submit" class="btn-primary">🔍 Cari</button>
            <?php if(isset($_GET['cari'])): ?>
                <a href="index.php?page=manajemen_penduduk" class="btn-danger" style="padding: 10px 15px; text-decoration: none; border-radius: 4px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama & Status</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($daftarPenduduk)): ?>
                        <tr><td colspan="5" style="text-align:center; padding: 20px;">Data tidak ditemukan.</td></tr>
                    <?php else: ?>
                        <?php foreach($daftarPenduduk as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u->nik) ?></td>
                                <td>
                                    <?= htmlspecialchars($u->nama_lengkap) ?><br>
                                    <?php 
                                        $bgStatus = 'green';
                                        if($u->status_kependudukan == 'Pindah') $bgStatus = 'orange';
                                        if($u->status_kependudukan == 'Meninggal') $bgStatus = 'black';
                                    ?>
                                    <span style="font-size: 11px; background: <?= $bgStatus ?>; color: white; padding: 2px 6px; border-radius: 4px;">
                                        <?= htmlspecialchars($u->status_kependudukan ?? 'Tetap') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($u->no_hp) ?><br><small><?= htmlspecialchars($u->email) ?></small></td>
                                <td><?= htmlspecialchars($u->alamat) ?></td>
                                
                                <td>
                                    <a href="index.php?page=form_penduduk&id=<?= $u->id ?>" style="color: #e0a800; font-weight: bold;">Edit/Mutasi</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>