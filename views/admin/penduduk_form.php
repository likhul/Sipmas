<?php
$isEdit = isset($pendudukEdit);
$title = $isEdit ? "Edit Data Penduduk" : "Tambah Penduduk Baru";
$actionUrl = $isEdit ? "index.php?action=update_penduduk" : "index.php?action=simpan_penduduk";
?>

<section id="form-penduduk-section">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <div style="margin-bottom: 15px;">
            <a href="index.php?page=manajemen_penduduk" style="text-decoration: none; color: #666;">&larr; Kembali</a>
        </div>

        <div class="card">
            <h2 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 15px; color: var(--primary);"><?= $title ?></h2>
            
            <form action="<?= $actionUrl ?>" method="POST">
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $pendudukEdit->id ?>">
                <?php endif; ?>

                <h4 style="color: #666; margin-bottom: 15px; text-decoration: underline;">A. Data KTP</h4>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label>NIK:</label>
                        <input type="text" name="nik" required pattern="\d{16}" title="16 Digit Angka" 
                               value="<?= $isEdit ? $pendudukEdit->nik : '' ?>" placeholder="16 Digit Angka"
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-weight: bold;">
                    </div>
                    <div>
                        <label>Nama Lengkap:</label>
                        <input type="text" name="nama" required 
                               value="<?= $isEdit ? $pendudukEdit->nama_lengkap : '' ?>" placeholder="Sesuai KTP"
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; text-transform: uppercase;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label>Tempat Lahir:</label>
                        <input type="text" name="tempat_lahir" value="<?= $isEdit ? $pendudukEdit->tempat_lahir : '' ?>" 
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                    <div>
                        <label>Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" value="<?= $isEdit ? $pendudukEdit->tanggal_lahir : '' ?>" 
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label>Jenis Kelamin:</label>
                        <select name="jenis_kelamin" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="Laki-laki" <?= ($isEdit && $pendudukEdit->jenis_kelamin == 'Laki-laki') ? 'selected' : '' ?>>LAKI-LAKI</option>
                            <option value="Perempuan" <?= ($isEdit && $pendudukEdit->jenis_kelamin == 'Perempuan') ? 'selected' : '' ?>>PEREMPUAN</option>
                        </select>
                    </div>
                    <div>
                        <label>Agama:</label>
                        <select name="agama" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="Islam" <?= ($isEdit && $pendudukEdit->agama == 'Islam') ? 'selected' : '' ?>>ISLAM</option>
                            <option value="Kristen" <?= ($isEdit && $pendudukEdit->agama == 'Kristen') ? 'selected' : '' ?>>KRISTEN</option>
                            <option value="Katolik" <?= ($isEdit && $pendudukEdit->agama == 'Katolik') ? 'selected' : '' ?>>KATOLIK</option>
                            <option value="Hindu" <?= ($isEdit && $pendudukEdit->agama == 'Hindu') ? 'selected' : '' ?>>HINDU</option>
                            <option value="Buddha" <?= ($isEdit && $pendudukEdit->agama == 'Buddha') ? 'selected' : '' ?>>BUDDHA</option>
                            <option value="Konghucu" <?= ($isEdit && $pendudukEdit->agama == 'Konghucu') ? 'selected' : '' ?>>KONGHUCU</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label>Status Perkawinan:</label>
                        <select name="status_perkawinan" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                            <option value="Belum Kawin" <?= ($isEdit && $pendudukEdit->status_perkawinan == 'Belum Kawin') ? 'selected' : '' ?>>BELUM KAWIN</option>
                            <option value="Kawin" <?= ($isEdit && $pendudukEdit->status_perkawinan == 'Kawin') ? 'selected' : '' ?>>KAWIN</option>
                            <option value="Cerai Hidup" <?= ($isEdit && $pendudukEdit->status_perkawinan == 'Cerai Hidup') ? 'selected' : '' ?>>CERAI HIDUP</option>
                            <option value="Cerai Mati" <?= ($isEdit && $pendudukEdit->status_perkawinan == 'Cerai Mati') ? 'selected' : '' ?>>CERAI MATI</option>
                        </select>
                    </div>
                    <div>
                        <label>Pekerjaan:</label>
                        <input type="text" name="pekerjaan" value="<?= $isEdit ? $pendudukEdit->pekerjaan : '' ?>" placeholder="PELAJAR/MAHASISWA/WIRASWASTA"
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; text-transform: uppercase;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Alamat Lengkap:</label>
                    <textarea name="alamat" rows="2" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><?= $isEdit ? $pendudukEdit->alamat : '' ?></textarea>
                </div>

                <h4 style="color: #666; margin-top: 30px; margin-bottom: 15px; text-decoration: underline;">B. Akun & Kontak</h4>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label>Email:</label>
                        <input type="email" name="email" required value="<?= $isEdit ? $pendudukEdit->email : '' ?>"
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                    <div>
                        <label>No. HP / WhatsApp:</label>
                        <input type="text" name="hp" value="<?= $isEdit ? $pendudukEdit->no_hp : '' ?>"
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Status Kependudukan:</label>
                    <select name="status_kependudukan" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #f0f8ff;">
                        <option value="Tetap" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Tetap') ? 'selected' : '' ?>>🟢 Warga Tetap</option>
                        <option value="Pindah" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Pindah') ? 'selected' : '' ?>>🟠 Pindah Keluar</option>
                        <option value="Meninggal" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Meninggal') ? 'selected' : '' ?>>⚫ Meninggal Dunia</option>
                    </select>
                </div>

                <div style="margin-bottom: 25px;">
                    <label>Password:</label>
                    <input type="password" name="password" 
                           placeholder="<?= $isEdit ? 'Biarkan kosong jika tidak ingin mengubah password' : 'Buat password baru' ?>"
                           <?= $isEdit ? '' : 'required' ?>
                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div style="text-align: right; border-top: 1px solid #eee; padding-top: 20px;">
                    <a href="index.php?page=manajemen_penduduk" class="btn-danger" style="text-decoration: none; margin-right: 10px; background: #6c757d;">Batal</a>
                    <button type="submit" class="btn-primary" style="padding: 10px 30px;">
                        <?= $isEdit ? '💾 Simpan Perubahan' : '💾 Tambah Data' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<script>
    const inputNIK = document.querySelector('input[name="nik"]');
    if(inputNIK) {
        inputNIK.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, ''); // Hapus huruf
            if(this.value.length > 16) this.value = this.value.slice(0, 16); // Max 16 digit
        });
    }
</script>