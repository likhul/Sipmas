<section>
    <div class="content-header">
        <div>
            <h2 style="margin: 0; color: var(--primary);">Dashboard Kepala Desa</h2>
            <p style="margin: 5px 0 0; color: #666;">Selamat bekerja, <strong> <?= htmlspecialchars($_SESSION['nama']) ?></strong>.</p>
        </div>
        <div style="text-align: right;">
            <span class="badge badge-warning" style="font-size: 0.9rem; padding: 10px 15px; background-color: #6f42c1; color: white;">
                <?= count($permohonanKades) ?> Perlu Tanda Tangan
            </span>
        </div>
    </div>

    <div class="card">
        <h3 style="color: #6f42c1;">✍ Permohonan Menunggu Persetujuan</h3>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">No. Registrasi</th>
                        <th style="text-align: center;">Nama Pemohon</th>
                        <th style="text-align: center;">Jenis Surat</th>
                        <th style="text-align: center;">Tanggal Masuk</th>
                        <th style="text-align: center;">Status</th>
                        <th style="width: 200px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($permohonanKades)): ?>
                        <tr><td colspan="6" style="text-align:center; padding: 40px; color: #888;">
                            🎉 Tidak ada tugas. Semua surat sudah disetujui.
                        </td></tr>
                    <?php else: ?>
                        <?php foreach ($permohonanKades as $p): ?>
                            <tr>
                                <td>
                                    <strong><?= $p->nomor_tiket ?></strong>
                                </td>
                                <td><?= htmlspecialchars($p->nama_pemohon) ?></td>
                                <td><?= htmlspecialchars($p->nama_layanan) ?></td>
                                <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
                                <td>
                                    <span class="badge" style="background-color: #6f42c1; color: white;">
                                        Menunggu Tanda Tangan
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 10px; justify-content: center;">
                                        <a href="index.php?page=detail_permohonan&id=<?= $p->id ?>" 
                                           class="btn-primary" 
                                           style="padding: 8px 12px; font-size: 0.85rem; background: #17a2b8;">
                                            👁 Cek
                                        </a>

                                        <form action="index.php?action=approval_kades" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui dan menerbitkan surat ini?');" style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $p->id ?>">
                                            <button type="submit" class="btn-warning" style="padding: 8px 12px; font-size: 0.85rem; border: 1px solid #e0a800;">
                                                ✍ Setujui
                                            </button>
                                        </form>
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