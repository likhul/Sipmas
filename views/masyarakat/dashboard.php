<section>
    <div style="background: linear-gradient(to right, #1a2a47, #2c436b); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div>
            <h2 style="margin: 0; color: white;">Halo, <?= htmlspecialchars($_SESSION['nama']) ?> 👋</h2>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Pantau status permohonan surat Anda di sini.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="border-left: 5px solid var(--primary); margin: 0;">
            <h3 style="border: none; margin-bottom: 10px;">📝 Layanan Surat</h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 20px;">Ajukan surat keterangan secara online.</p>
            <a href="index.php?page=ajukan_surat" style="color: var(--primary); font-weight: 600; text-decoration: none;">Akses Layanan &rarr;</a>
        </div>
        <div class="card" style="border-left: 5px solid #fd7e14; margin: 0;">
            <h3 style="border: none; margin-bottom: 10px;">💬 Pengaduan</h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 20px;">Sampaikan aspirasi kepada desa.</p>
            <a href="index.php?page=pengaduan_saya" style="color: #fd7e14; font-weight: 600; text-decoration: none;">Tulis Pesan &rarr;</a>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top: 0; border-bottom: none;">Riwayat & Progress Permohonan</h3>
        
        <div class="table-responsive">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nomor Tiket / Surat</th>
                        <th style="width: 25%;">Jenis Surat</th>
                        <th style="width: 30%;">Status & Progress</th> <th style="width: 20%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                    <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                                    <h4 style="margin: 0; color: #555;">Belum ada data</h4>
                                    <p style="font-size: 0.9rem;">Saat ini belum ada surat atau permohonan di sini.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                        <?php $no=1; foreach ($riwayat as $r): ?>
                            <tr>
                                <td data-label="No"><?= $no++ ?></td>
                                
                                <td data-label="Nomor">
                                    <?php if($r->nomor_surat_resmi): ?>
                                        <span style="font-weight:bold; color:var(--primary);"><?= $r->nomor_surat_resmi ?></span><br>
                                        <small style="color:green;">✅ Terbit: <?= date('d/m/y', strtotime($r->updated_at)) ?></small>
                                    <?php else: ?>
                                        <span style="color:#666;"><?= $r->nomor_tiket ?></span><br>
                                        <small style="color:#999;">Diajukan: <?= date('d/m/y', strtotime($r->created_at)) ?></small>
                                    <?php endif; ?>
                                </td>
                                
                                <td data-label="Jenis"><strong><?= htmlspecialchars($r->nama_layanan) ?></strong></td>
                                
                                <td data-label="Progress">
                                    <?php 
                                        // Logika Progress Bar
                                        $label = ucfirst(str_replace('_', ' ', $r->status));
                                        $badgeClass = 'badge-warning';
                                        $progClass = 'prog-pending'; // Default 15%

                                        if ($r->status == 'verifikasi_admin') {
                                            $progClass = 'prog-verifikasi'; // 50%
                                            $label = "Verifikasi Admin";
                                        } 
                                        elseif ($r->status == 'menunggu_kades') {
                                            $progClass = 'prog-ttd'; // 80%
                                            $label = "Menunggu TTD Kades";
                                            $badgeClass = 'badge-info'; // Warna ungu/biru
                                        } 
                                        elseif ($r->status == 'disetujui' || $r->status == 'selesai') {
                                            $progClass = 'prog-selesai'; // 100%
                                            $label = "Selesai / Disetujui";
                                            $badgeClass = 'badge-success';
                                        } 
                                        elseif ($r->status == 'ditolak') {
                                            $progClass = 'prog-tolak'; // Merah Penuh
                                            $badgeClass = 'badge-danger';
                                        }
                                    ?>
                                    
                                    <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:5px;">
                                        <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                                    </div>

                                    <div class="progress-track">
                                        <div class="progress-fill <?= $progClass ?>"></div>
                                    </div>
                                </td>

                                <td data-label="Aksi" style="text-align: center;">
                                    <?php if ($r->status == 'disetujui' || $r->status == 'selesai'): ?>
                                        <a href="index.php?page=cetak_surat&id=<?= $r->id ?>" target="_blank" 
                                           class="btn-success" style="padding: 6px 12px; font-size: 0.8rem; text-decoration:none; color:white;">
                                            ⬇ Unduh
                                        </a>
                                    <?php elseif($r->status == 'ditolak'): ?>
                                        <div style="font-size:0.8rem; color:var(--danger); font-weight:bold;">
                                            Ditolak
                                        </div>
                                        <small style="font-style:italic;">Cek alasan di Admin</small>
                                    <?php else: ?>
                                        <span style="color: #ccc; font-size:0.8rem;">- Menunggu -</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h3 style="color: var(--primary);">📢 Papan Informasi Desa</h3>
        <?php if(empty($daftarInfo)): ?>
            <p style="color: #666;">Tidak ada pengumuman terbaru.</p>
        <?php else: ?>
            <div style="display: grid; gap: 15px;">
                <?php foreach($daftarInfo as $info): ?>
                    <div class="info-card">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span class="badge badge-info"><?= htmlspecialchars($info->kategori) ?></span>
                            <small style="color: #999;"><?= date('d M Y', strtotime($info->tanggal_posting)) ?></small>
                        </div>
                        <h4 style="margin: 5px 0; color: #333; font-size: 1.1rem;"><?= htmlspecialchars($info->judul) ?></h4>
                        <p style="color: #555; font-size: 0.9rem; margin: 0;"><?= nl2br(htmlspecialchars($info->isi_konten)) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>