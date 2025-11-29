<section style="padding-top: 20px;">
    
    <div class="card" style="max-width: 800px; margin: 0 auto 40px auto; padding: 0; overflow: hidden; border-top: 5px solid #fd7e14;">
        
        <div style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="margin: 0; color: #333; font-size: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    💬 Layanan Pengaduan
                </h2>
                <p style="margin: 5px 0 0; color: #666; font-size: 0.9rem;">
                    Sampaikan kritik, saran, atau aspirasi Anda kepada desa.
                </p>
            </div>
            
            <a href="index.php?page=dashboard_warga" class="btn-warning" style="text-decoration: none; border-radius: 8px; font-size: 0.9rem; padding: 8px 18px;">
                ← Kembali
            </a>
        </div>

        <div style="padding: 30px;">
            <form action="index.php?action=kirim_pengaduan" method="POST">
                
                <div style="margin-bottom: 25px;">
                    <label style="font-weight: bold; margin-bottom: 8px; display: block; color: #333;">Subjek / Judul Laporan:</label>
                    <div style="background: #fff8f3; padding: 10px; border-radius: 8px; border: 1px solid #ffeeba; display: flex; align-items: center;">
                        <span style="font-size: 1.2rem; margin-right: 10px;">📢</span>
                        <input type="text" name="subjek" required placeholder="Contoh: Lampu Jalan Mati di RT 05" 
                               style="width: 100%; border: none; background: transparent; font-size: 1rem; outline: none; color: #333;">
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <label style="font-weight: bold; margin-bottom: 8px; display: block; color: #333;">Isi Pengaduan Lengkap:</label>
                    <div style="background: #fff8f3; padding: 10px; border-radius: 8px; border: 1px solid #ffeeba; display: flex; align-items: flex-start;">
                        <span style="font-size: 1.2rem; margin-right: 10px; margin-top: 2px;">📝</span>
                        <textarea name="isi" rows="5" required placeholder="Jelaskan detail permasalahan, lokasi, dan waktu kejadian..." 
                                  style="width: 100%; border: none; background: transparent; font-size: 1rem; outline: none; resize: vertical; font-family: inherit;"></textarea>
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn-primary" style="padding: 12px 30px; border-radius: 50px; font-size: 1rem; background: #fd7e14; border: none; box-shadow: 0 4px 10px rgba(253, 126, 20, 0.3);">
                        ✉️ Kirim Laporan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 15px; color: var(--primary);">
            📜 Riwayat Aspirasi Saya
        </h3>
        
        <div class="table-responsive">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 20%;">Tanggal</th>
                        <th style="width: 30%;">Subjek</th>
                        <th style="width: 35%;">Isi Ringkas</th>
                        <th style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPengaduan)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #888;">
                                <div style="font-size: 2.5rem; margin-bottom: 10px;">📭</div>
                                Belum ada pengaduan yang dikirim.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($daftarPengaduan as $p): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
                            <td style="font-weight: bold; color: var(--primary);"><?= htmlspecialchars($p->subjek) ?></td>
                            <td style="color: #555;"><?= substr(htmlspecialchars($p->isi_pengaduan), 0, 50) ?>...</td>
                            
                            <td>
                                <?php 
                                    $bg = '#6c757d'; 
                                    if($p->status == 'Dibaca') $bg = '#17a2b8';  
                                    if($p->status == 'Selesai') $bg = '#28a745'; 
                                ?>
                                <span class="badge" style="background: <?= $bg ?>; color: white; padding: 6px 12px; border-radius: 50px;">
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