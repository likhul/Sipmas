<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: var(--primary);">Ajukan Surat Baru</h2>
        <a href="index.php?page=dashboard_warga" style="text-decoration: none; color: #666; font-size: 0.9rem;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="card" style="max-width: 700px; margin: 0 auto; padding: 30px;">
        
        <form action="index.php?action=simpan_permohonan" method="POST" enctype="multipart/form-data">
            
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block;">Jenis Surat:</label>
                <select name="jenis_surat" id="jenis_surat" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background-color: #f9f9f9;">
                    <option value="" disabled selected>-- Pilih Jenis Layanan --</option>
                    <?php foreach($daftarLayanan as $layanan): ?>
                        <option value="<?= $layanan->id ?>">
                            <?= $layanan->nama_layanan ?> (Kode: <?= $layanan->kode_surat ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block;">Keperluan:</label>
                <input type="text" name="keperluan" id="keperluan" placeholder="Contoh: Persyaratan melamar pekerjaan" required 
                       style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block;">Keterangan Tambahan / Detail:</label>
                <textarea name="keterangan_tambahan" id="keterangan" rows="3" placeholder="Isi jika ada informasi tambahan..." 
                          style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc;"></textarea>
            </div>

            <div style="background-color: #f0f4f8; padding: 20px; border-radius: 10px; border: 1px dashed var(--primary); margin-bottom: 25px;">
                <label style="font-weight: bold; color: var(--primary); margin-bottom: 10px; display: block;">
                    📂 Unggah Dokumen Pendukung (KTP/KK)
                </label>
                
                <input type="file" name="dokumen_pendukung" id="dokumen" required accept=".pdf,.jpg,.jpeg,.png" 
                       style="width: 100%; background: white; padding: 10px;">
                
                <p style="margin: 1px 0 0; font-size: 0.85rem; color: #666;">
                    *Format: PDF atau JPG. Maksimal 5MB.
                </p>
            </div>

            <div style="border-top: 1px solid #eee; padding-top: 20px; text-align: right; display: flex; justify-content: flex-end; gap: 15px; align-items: center;">
                <a href="index.php?page=dashboard_warga" style="text-decoration: none; color: #666; font-weight: 500;">Batal</a>
                
                <button type="submit" class="btn-primary" style="padding: 12px 30px; border-radius: 30px; font-size: 1rem; box-shadow: 0 4px 10px rgba(26, 42, 71, 0.3);">
                    Kirim Permohonan
                </button>
            </div>

        </form>
    </div>
</section>