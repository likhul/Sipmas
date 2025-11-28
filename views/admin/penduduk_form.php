<?php
// Cek apakah mode Edit atau Tambah
$isEdit = isset($pendudukEdit);
$title = $isEdit ? "Edit Data Penduduk" : "Tambah Penduduk Baru";
$actionUrl = $isEdit ? "index.php?action=update_penduduk" : "index.php?action=simpan_penduduk";
?>

<section id="form-penduduk-section">
    <div style="max-width: 600px; margin: 0 auto;">
        <h2><?= $title ?></h2>
        <div class="card">
            <form action="<?= $actionUrl ?>" method="POST">
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $pendudukEdit->id ?>">
                <?php endif; ?>

                <label>NIK (Nomor Induk Kependudukan):</label>
                <input type="text" name="nik" required pattern="\d{16}" title="16 Digit Angka" 
                       value="<?= $isEdit ? $pendudukEdit->nik : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required 
                       value="<?= $isEdit ? $pendudukEdit->nama_lengkap : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Email (Untuk Login):</label>
                <input type="email" name="email" required 
                       value="<?= $isEdit ? $pendudukEdit->email : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Nomor HP/WhatsApp:</label>
                <input type="text" name="hp" 
                       value="<?= $isEdit ? $pendudukEdit->no_hp : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                <label>Alamat Lengkap:</label>
                <textarea name="alamat" rows="3" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><?= $isEdit ? $pendudukEdit->alamat : '' ?></textarea>

                <label>Status Kependudukan (Mutasi):</label>
                <select name="status_kependudukan" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="Tetap" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Tetap') ? 'selected' : '' ?>>Warga Tetap</option>
                    <option value="Pindah" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Pindah') ? 'selected' : '' ?>>Pindah Keluar</option>
                    <option value="Meninggal" <?= (isset($pendudukEdit) && $pendudukEdit->status_kependudukan == 'Meninggal') ? 'selected' : '' ?>>Meninggal Dunia</option>
                </select>
                
                <label>Password:</label>
                <input type="password" name="password" 
                       placeholder="<?= $isEdit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password baru' ?>"
                       <?= $isEdit ? '' : 'required' ?>
                       style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

                <div style="text-align: right;">
                    <a href="index.php?page=manajemen_penduduk" style="margin-right: 15px; text-decoration: none; color: #666;">Batal</a>
                    <button type="submit" style="background: var(--primary-color); color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer;">
                        Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<script>
    // Cari semua input dengan nama 'nik'
    const inputNIK = document.querySelector('input[name="nik"]');
    
    if(inputNIK) {
        // Event Listener: Setiap kali mengetik
        inputNIK.addEventListener('input', function(e) {
            // Ganti semua karakter selain angka (0-9) dengan string kosong
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Potong jika lebih dari 16
            if(this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    }
</script>