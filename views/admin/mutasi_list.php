<section>
    <div style="margin-bottom: 20px;">
        <a href="index.php?page=dashboard_admin" style="text-decoration: none; color: #666;">&larr; Kembali ke Dashboard</a>
    </div>
    
    <h2>Pencatatan Mutasi Penduduk</h2>

    <div class="card" style="background: #fff3cd; border: 1px solid #ffeeba;">
        <h3>Catat Peristiwa Baru</h3>
        <form action="index.php?action=simpan_mutasi" method="POST">
            <div style="display: flex; gap: 10px;">
                <div style="flex: 2;">
                    <label>Pilih Warga:</label>
                    <select name="user_id" required style="width: 100%; padding: 8px;">
                        <option value="">-- Pilih Penduduk --</option>
                        <?php foreach($semuaWarga as $w): ?>
                            <option value="<?= $w->id ?>"><?= $w->nama_lengkap ?> (<?= $w->nik ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Jenis Mutasi:</label>
                    <select name="jenis_mutasi" required style="width: 100%; padding: 8px;">
                        <option value="Keluar">Pindah Keluar</option>
                        <option value="Meninggal">Meninggal Dunia</option>
                        <option value="Masuk">Pindah Masuk</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" style="width: 100%; padding: 8px;">
                </div>
            </div>
            <label style="margin-top: 10px;">Keterangan:</label>
            <input type="text" name="keterangan" placeholder="Contoh: Pindah ke Kota Jambi karena pekerjaan" style="width: 100%; padding: 8px;">
            
            <button type="submit" class="btn-primary" style="margin-top: 10px;">Simpan Data Mutasi</button>
        </form>
    </div>

    <h3>Riwayat Mutasi Desa</h3>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Warga</th>
                    <th>Jenis Peristiwa</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($daftarMutasi as $m): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($m->tanggal_mutasi)) ?></td>
                    <td><?= $m->nama_lengkap ?><br><small><?= $m->nik ?></small></td>
                    <td>
                        <span class="badge" style="background: <?= $m->jenis_mutasi=='Meninggal'?'black':($m->jenis_mutasi=='Keluar'?'orange':'green') ?>; color:white;">
                            <?= $m->jenis_mutasi ?>
                        </span>
                    </td>
                    <td><?= $m->keterangan ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>