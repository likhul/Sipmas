<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: var(--primary);">Semua Riwayat Permohonan</h2>
        <a href="index.php?page=dashboard_warga" class="btn-warning" style="text-decoration: none; border-radius: 5px; font-size: 0.9rem;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">No. Registrasi</th> <th style="width: 15%;">Tanggal</th>
                        <th style="width: 25%;">Jenis Surat</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 15%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr><td colspan="6" style="text-align: center; color: #888; padding: 30px;">Belum ada riwayat permohonan.</td></tr>
                    <?php else: ?>
                        <?php $no=1; foreach ($riwayat as $r): ?>
                            <tr>
                                <td data-label="No"><?= $no++ ?></td>
                                
                                <td data-label="Nomor">
                                    <?php if($r->nomor_surat_resmi): ?>
                                        <span style="font-weight:bold; color:var(--primary);"><?= $r->nomor_surat_resmi ?></span>
                                    <?php else: ?>
                                        <span style="color:#666;"><?= $r->nomor_tiket ?></span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="Tanggal"><?= date('d/m/Y', strtotime($r->created_at)) ?></td>
                                <td data-label="Jenis"><strong><?= htmlspecialchars($r->nama_layanan) ?></strong></td>
                                
                                <td data-label="Status">
                                    <?php 
                                        $statusClass = 'badge-warning';
                                        if(in_array($r->status, ['disetujui','selesai'])) $statusClass = 'badge-success';
                                        if($r->status == 'ditolak') $statusClass = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $statusClass ?>">
                                        <?= ucfirst(str_replace('_', ' ', $r->status)) ?>
                                    </span>
                                </td>

                                <td data-label="Aksi" style="text-align: center;">
                                    <?php if (in_array($r->status, ['disetujui','selesai'])): ?>
                                        <a href="index.php?page=cetak_surat&id=<?= $r->id ?>" target="_blank" 
                                           class="btn-success" style="padding: 6px 10px; font-size: 0.8rem; text-decoration:none; color:white;">
                                            ⬇ Unduh
                                        </a>
                                    <?php elseif($r->status == 'ditolak'): ?>
                                        <span style="color: var(--danger); font-size: 0.8rem;">Ditolak</span>
                                    <?php else: ?>
                                        <span style="color: #ccc; font-size: 0.8rem;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>