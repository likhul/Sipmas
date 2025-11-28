<section id="masyarakat-dashboard">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Riwayat Permohonan Surat (SIA-12)</h2>
        <a href="index.php?page=ajukan_surat" class="btn-primary" style="text-decoration: none; background: var(--primary-color); color: white; padding: 10px 20px; border-radius: 5px;">+ Ajukan Baru</a>
    </div>

    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Tanggal</th>
                        <th>Jenis Layanan</th>
                        <th>Status Saat Ini</th>
                        <th>Keterangan / Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                Belum ada riwayat permohonan. Silakan ajukan surat baru.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td data-label="No. Tiket"><strong><?= $r->nomor_tiket ?></strong></td>
                                
                                <td data-label="Tanggal"><?= date('d-m-Y', strtotime($r->created_at)) ?></td>
                                
                                <td data-label="Jenis Layanan"><?= $r->nama_layanan ?></td>
                                
                                <td data-label="Status">
                                    <?php 
                                        $warna = '#6c757d'; // Default abu-abu
                                        $label = ucfirst(str_replace('_', ' ', $r->status)); 

                                        if ($r->status == 'pending') $warna = '#ffaa33'; // Kuning
                                        elseif ($r->status == 'verifikasi_admin') $warna = '#17a2b8'; // Biru
                                        elseif ($r->status == 'menunggu_kades') $warna = '#6610f2'; // Ungu
                                        elseif ($r->status == 'disetujui' || $r->status == 'selesai') $warna = '#28a745'; // Hijau
                                        elseif ($r->status == 'ditolak') $warna = '#dc3545'; // Merah
                                    ?>
                                    <span style="background-color: <?= $warna ?>; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; display: inline-block;">
                                        <?= $label ?>
                                    </span>
                                </td>

                                <td data-label="Aksi">
                                    <?php if ($r->status == 'ditolak'): ?>
                                        <small style="color: var(--danger-color);">
                                            Alasan: <?= $r->keterangan_status ?>
                                        </small>
                                    
                                    <?php elseif ($r->status == 'disetujui' || $r->status == 'selesai'): ?>
                                        <a href="index.php?page=cetak_surat&id=<?= $r->id ?>" target="_blank" 
                                           style="background: #28a745; border: none; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block;">
                                            ⬇ Unduh / Cetak
                                        </a>
                                    
                                    <?php else: ?>
                                        <small style="color: #888;">Sedang diproses petugas</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?> 
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="index.php?page=dashboard_warga" style="color: var(--primary-color); text-decoration: none;">&larr; Kembali ke Dashboard</a>
    </div>
</section>