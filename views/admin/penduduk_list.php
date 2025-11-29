<section id="manajemen-penduduk">
    
    <div class="content-header">
        <div>
            <h2 style="margin: 0; color: var(--primary);">👥 Data Kependudukan</h2>
            <p style="margin: 5px 0 0; color: #666;">Database lengkap penduduk desa.</p>
        </div>
        <a href="index.php?page=form_penduduk" class="btn-primary" style="text-decoration: none; border-radius: 5px; padding: 10px 20px; display: flex; align-items: center; gap: 8px;">
            <span>+</span> Tambah Warga
        </a>
    </div>

    <div class="card" style="padding: 20px; margin-bottom: 20px; background: white; border-left: 5px solid var(--accent);">
        <form action="index.php" method="GET" style="display: flex; gap: 10px; margin: 0;">
            <input type="hidden" name="page" value="manajemen_penduduk">
            <input type="text" name="cari" placeholder="Ketik Nama atau NIK warga..." value="<?= $_GET['cari'] ?? '' ?>" 
                   style="flex: 1; margin: 0; padding: 12px; border: 2px solid #eee; border-radius: 8px;">
            <button type="submit" class="btn-primary" style="padding: 0 30px;">🔍 Cari</button>
            <?php if(isset($_GET['cari'])): ?>
                <a href="index.php?page=manajemen_penduduk" class="btn-danger" style="padding: 12px 20px; text-decoration: none; border-radius: 8px; display: flex; align-items: center;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="width: 25%; padding: 15px;">Profil Utama</th>
                        <th style="width: 35%; padding: 15px;">Detail Biodata</th>
                        <th style="width: 25%; padding: 15px;">Domisili & Kontak</th>
                        <th style="width: 15%; text-align: center; padding: 15px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($daftarPenduduk)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 50px; color: #888;">
                                <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                                <h4>Data tidak ditemukan</h4>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($daftarPenduduk as $u): ?>
                        <tr>
                            <td style="vertical-align: top; padding: 20px; border-bottom: 1px solid #eee;">
                                <div style="margin-bottom: 5px;">
                                    <strong style="font-size: 1.1rem; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px;">
                                        <?= htmlspecialchars($u->nama_lengkap) ?>
                                    </strong>
                                </div>
                                <div style="font-family: 'Courier New', monospace; font-weight: bold; color: #555; background: #f1f1f1; padding: 3px 8px; border-radius: 4px; display: inline-block; font-size: 0.9rem;">
                                    <?= htmlspecialchars($u->nik) ?>
                                </div>
                                
                                <div style="margin-top: 15px;">
                                    <?php 
                                        $bgStatus = '#28a745'; 
                                        $labelStatus = 'Warga Tetap';
                                        if($u->status_kependudukan == 'Pindah') { $bgStatus = '#ffc107'; $labelStatus = 'Pindah'; }
                                        elseif($u->status_kependudukan == 'Meninggal') { $bgStatus = '#343a40'; $labelStatus = 'Meninggal'; }
                                    ?>
                                    <span class="badge" style="background-color: <?= $bgStatus ?>; color: white; font-weight: 500; padding: 5px 10px;">
                                        <?= $labelStatus ?>
                                    </span>
                                </div>
                            </td>

                            <td style="vertical-align: top; padding: 20px; border-bottom: 1px solid #eee;">
                                <div style="display: grid; grid-template-columns: 90px auto; row-gap: 8px; font-size: 0.9rem; color: #444;">
                                    
                                    <span style="color: #888;">TTL</span>
                                    <span>: <?= htmlspecialchars($u->tempat_lahir ?? '-') ?>, <?= $u->tanggal_lahir ? date('d-m-Y', strtotime($u->tanggal_lahir)) : '-' ?></span>
                                    
                                    <span style="color: #888;">Gender</span>
                                    <span>: <?= htmlspecialchars($u->jenis_kelamin ?? '-') ?></span>
                                    
                                    <span style="color: #888;">Agama</span>
                                    <span>: <?= htmlspecialchars($u->agama ?? '-') ?></span>
                                    
                                    <span style="color: #888;">Status</span>
                                    <span>: <?= htmlspecialchars($u->status_perkawinan ?? '-') ?></span>
                                    
                                    <span style="color: #888;">Pekerjaan</span>
                                    <span>: <?= htmlspecialchars($u->pekerjaan ?? '-') ?></span>
                                </div>
                            </td>

                            <td style="vertical-align: top; padding: 20px; border-bottom: 1px solid #eee;">
                                <div style="margin-bottom: 12px;">
                                    <strong style="display: block; font-size: 0.8rem; color: #888; margin-bottom: 3px;">ALAMAT:</strong>
                                    <span style="line-height: 1.4; display: block;">
                                        <?= nl2br(htmlspecialchars($u->alamat)) ?>
                                    </span>
                                </div>
                                
                                <div style="font-size: 0.85rem; color: #555; border-top: 1px dashed #ddd; padding-top: 10px;">
                                    <div style="margin-bottom: 5px;">
                                        <span style="margin-right: 5px;">📱</span> <?= htmlspecialchars($u->no_hp ?? '-') ?>
                                    </div>
                                    <div>
                                        <span style="margin-right: 5px;">📧</span> <?= htmlspecialchars($u->email) ?>
                                    </div>
                                </div>
                            </td>

                            <td style="vertical-align: middle; padding: 20px; border-bottom: 1px solid #eee; text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <a href="index.php?page=form_penduduk&id=<?= $u->id ?>" 
                                       class="btn-warning" 
                                       style="padding: 8px 15px; font-size: 0.85rem; text-decoration: none; border-radius: 6px; text-align: center; font-weight: 600;">
                                       ✏ Edit Data
                                    </a>
                                    
                                    <a href="#" onclick="showPopup('delete', 'Hapus Data?', 'Data penduduk <?= htmlspecialchars($u->nama_lengkap) ?> akan dihapus permanen.', () => window.location.href='index.php?action=hapus_penduduk&id=<?= $u->id ?>')" class="btn-action btn-delete">
                                        <span class="icon">🗑️</span> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>