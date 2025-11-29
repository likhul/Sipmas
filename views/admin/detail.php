<section id="detail-permohonan">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Detail Permohonan & Verifikasi Berkas</h2>
        <a href="javascript:history.back()" style="text-decoration: none; color: #666;">&larr; Kembali</a>
    </div>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <div class="card" style="flex: 1; min-width: 300px;">
            <h3>Data Pemohon</h3>
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 120px; font-weight: bold; padding: 8px 0;">Nama Lengkap</td>
                    <td>: <?= $detail->nama_lengkap ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px 0;">NIK</td>
                    <td>: <?= $detail->nik ?? '-' ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px 0;">Alamat</td>
                    <td>: <?= $detail->alamat ?></td>
                </tr>
            </table>

            <h3 style="margin-top: 20px;">Data Surat</h3>
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 120px; font-weight: bold; padding: 8px 0;">Jenis Layanan</td>
                    <td>: <strong><?= $detail->nama_layanan ?></strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px 0;">No. Registrasi</td>
                    <td>: <?= $detail->nomor_tiket ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px 0;">Tanggal Ajuan</td>
                    <td>: <?= date('d F Y', strtotime($detail->created_at)) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px 0;">Status Saat Ini</td>
                    <td>: <span class="badge"><?= strtoupper(str_replace('_', ' ', $detail->status)) ?></span></td>
                </tr>
            </table>

            <?php 
                //Keperluan/Keterangan)
                $infoTambahan = json_decode($detail->data_pengaju, true);
            ?>
            <div style="margin-top: 15px; background: #f9f9f9; padding: 10px; border-radius: 5px;">
                <strong>Keperluan:</strong><br>
                <?= $infoTambahan['keperluan'] ?? '-' ?><br><br>
                <strong>Keterangan Tambahan:</strong><br>
                <?= $infoTambahan['keterangan'] ?? '-' ?>
            </div>
        </div>

        <div class="card" style="flex: 1; min-width: 300px;">
            <h3>Berkas Lampiran (Syarat)</h3>
            
            <?php if(empty($detail->dokumen)): ?>
                <p style="color: red;">Tidak ada dokumen yang diunggah.</p>
            <?php else: ?>
                <div style="display: grid; gap: 15px;">
                    <?php foreach($detail->dokumen as $doc): ?>
                        <div style="border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                            <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 14px;">
                                📄 <?= $doc->nama_file ?>
                            </p>
                            
                            <?php 
                                $ext = pathinfo($doc->path_file, PATHINFO_EXTENSION);
                                if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): 
                            ?>
                                <img src="<?= $doc->path_file ?>" alt="Preview Dokumen" style="width: 100%; max-height: 300px; object-fit: contain; border: 1px solid #eee;">
                            <?php else: ?>
                                <a href="<?= $doc->path_file ?>" target="_blank" class="btn-primary" style="display: block; text-align: center; text-decoration: none; padding: 10px; background: #17a2b8; color: white; border-radius: 5px;">
                                    Lihat Dokumen PDF
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($_SESSION['role'] == 'admin' && $detail->status == 'pending'): ?>
    <div class="card" style="margin-top: 20px; background: #e9ecef; border-color: #dee2e6;">
        <h3>Keputusan Verifikasi</h3>
        <p>Apakah data dan dokumen di atas sudah valid?</p>
        
        <div style="display: flex; gap: 10px;">
            <form action="index.php?action=verifikasi_admin" method="POST">
                <input type="hidden" name="id" value="<?= $detail->id ?>">
                <input type="hidden" name="keputusan" value="terima">
                <button type="submit" style="background: #28a745; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                    ✅ Dokumen Valid & Teruskan
                </button>
            </form>

            <button onclick="bukaModalTolak(<?= $detail->id ?>)" style="background: #dc3545; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                ❌ Dokumen Tidak Valid / Tolak
            </button>
        </div>
    </div>
    <?php endif; ?>
</section>

<script>
function bukaModalTolak(idPermohonan) {
    const modal = document.getElementById('custom-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalText = document.getElementById('modal-text-content');
    const btnConfirm = document.getElementById('modal-submit-btn');
    const textarea = document.getElementById('modal-alasan');

    modal.classList.remove('hidden');
    modalTitle.textContent = "Tolak Permohonan";
    modalText.textContent = "Alasan penolakan (Wajib diisi):";
    textarea.value = "";
    
    btnConfirm.onclick = function() {
        const alasan = textarea.value;
        if(!alasan.trim()) { alert("Alasan tidak boleh kosong!"); return; }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?action=verifikasi_admin';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = idPermohonan;
        
        const inputKeputusan = document.createElement('input');
        inputKeputusan.type = 'hidden';
        inputKeputusan.name = 'keputusan';
        inputKeputusan.value = 'tolak';
        
        const inputAlasan = document.createElement('input');
        inputAlasan.type = 'hidden';
        inputAlasan.name = 'alasan';
        inputAlasan.value = alasan;

        form.appendChild(inputId);
        form.appendChild(inputKeputusan);
        form.appendChild(inputAlasan);
        document.body.appendChild(form);
        form.submit();
    };
}
</script>