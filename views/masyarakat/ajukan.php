<section style="padding-top: 20px;">
    
    <div class="card" style="max-width: 800px; margin: 0 auto 20px auto; padding: 25px 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; color: var(--primary); font-size: 1.5rem; display: flex; align-items: center; gap: 10px;">
                ✉️ Ajukan Surat
            </h2>
            <p style="margin: 5px 0 0; color: #666; font-size: 0.9rem;">
                Isi formulir di bawah ini dengan data yang benar.
            </p>
        </div>
        
        <a href="index.php?page=dashboard_warga" class="btn-warning" style="text-decoration: none; border-radius: 8px; font-size: 0.9rem; padding: 8px 18px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 30px; border-top: 5px solid var(--primary);">
        
        <form action="index.php?action=simpan_permohonan" method="POST" enctype="multipart/form-data">
            
            <div style="margin-bottom: 25px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block; color: var(--primary);">
                    Pilih Jenis Layanan Surat:
                </label>
                <div style="background: #f9f9f9; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <span style="font-size: 1.2rem; margin-right: 10px;">📑</span>
                    <select name="jenis_surat" id="jenis_surat" required onchange="updateSyarat()" 
                            style="width: 90%; border: none; background: transparent; font-size: 1rem; outline: none;">
                        <option value="" disabled selected>-- Silakan Pilih Surat --</option>
                        <?php foreach($daftarLayanan as $layanan): ?>
                            <option value="<?= $layanan->id ?>" data-syarat='<?= $layanan->syarat_dokumen ?>'>
                                <?= $layanan->nama_layanan ?> (Kode: <?= $layanan->kode_surat ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="info-syarat" style="background: #e3f2fd; border-left: 5px solid #2196f3; padding: 15px; border-radius: 8px; margin-bottom: 25px; display: none;">
                <h4 style="margin: 0 0 5px; color: #0d47a1; font-size: 0.95rem;">📋 Dokumen Persyaratan:</h4>
                <ul id="list-syarat" style="margin: 0; padding-left: 20px; color: #333; font-size: 0.9rem;"></ul>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block; color: var(--primary);">Keperluan:</label>
                <div style="background: #f9f9f9; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <span style="font-size: 1.2rem; margin-right: 10px;">🎯</span>
                    <input type="text" name="keperluan" placeholder="Contoh: Untuk melamar pekerjaan di PT..." required 
                           style="width: 90%; border: none; background: transparent; font-size: 1rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: bold; margin-bottom: 8px; display: block; color: var(--primary);">Keterangan Tambahan (Opsional):</label>
                <div style="background: #f9f9f9; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <textarea name="keterangan_tambahan" rows="3" placeholder="Catatan tambahan..." 
                              style="width: 100%; border: none; background: transparent; font-size: 1rem; outline: none; resize: vertical;"></textarea>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="font-weight: bold; margin-bottom: 10px; display: block; color: var(--primary);">Unggah Dokumen Pendukung:</label>
                
                <div style="border: 2px dashed #ccc; border-radius: 10px; padding: 30px; text-align: center; background: #fafafa; position: relative;">
                    <input type="file" name="dokumen_pendukung[]" id="fileInput" multiple required accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName()"
                           style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;">
                    
                    <div style="font-size: 2rem; margin-bottom: 10px;">☁️</div>
                    <strong style="display: block; color: #555;">Klik di sini untuk memilih file</strong>
                    <small style="color: #999;">Format: PDF, JPG, PNG (Max 5MB)</small>
                    
                    <div id="fileList" style="margin-top: 15px; font-weight: bold; color: var(--success);"></div>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(26, 42, 71, 0.2); font-weight: 600;">
                Kirim Permohonan
            </button>

        </form>
    </div>
</section>

<script>
function updateSyarat() {
    var select = document.getElementById("jenis_surat");
    var selectedOption = select.options[select.selectedIndex];
    var syaratRaw = selectedOption.getAttribute("data-syarat");
    var infoBox = document.getElementById("info-syarat");
    var list = document.getElementById("list-syarat");
    list.innerHTML = "";
    if (syaratRaw) {
        try {
            var syaratArr = JSON.parse(syaratRaw);
            if (Array.isArray(syaratArr)) {
                syaratArr.forEach(item => { var li = document.createElement("li"); li.textContent = item; list.appendChild(li); });
            } else { list.innerHTML = "<li>" + syaratRaw + "</li>"; }
            infoBox.style.display = "block";
        } catch (e) {
            list.innerHTML = "<li>" + syaratRaw.replace(/[\[\]"]/g, '') + "</li>"; infoBox.style.display = "block";
        }
    } else { infoBox.style.display = "none"; }
}
function updateFileName() {
    var input = document.getElementById('fileInput');
    var output = document.getElementById('fileList');
    var files = input.files;
    if (files.length > 0) {
        var fileNames = "📄 Terpilih: ";
        for (var i = 0; i < files.length; i++) { fileNames += files[i].name + (i < files.length - 1 ? ", " : ""); }
        output.textContent = fileNames;
    } else { output.textContent = ""; }
}
</script>