<?php
$isEdit = isset($stafEdit);
$title = $isEdit ? "Edit Akun Pegawai" : "Tambah Pegawai Baru";
$action = $isEdit ? "index.php?action=update_staf" : "index.php?action=simpan_staf";
?>

<section>
    <div style="max-width: 600px; margin: 0 auto;">
        <h2><?= $title ?></h2>
        <div class="card">
            <form action="<?= $action ?>" method="POST">
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $stafEdit->id ?>">
                <?php endif; ?>

                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required value="<?= $isEdit ? $stafEdit->nama_lengkap : '' ?>" 
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:5px;">

                <label>Role Akun:</label>
                <select name="role" required style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:5px;">
                    <option value="admin" <?= ($isEdit && $stafEdit->role=='admin')?'selected':'' ?>>Admin / Operator</option>
                    <option value="kades" <?= ($isEdit && $stafEdit->role=='kades')?'selected':'' ?>>Kepala Desa</option>
                </select>

                <label>Jabatan (Opsional):</label>
                <input type="text" name="jabatan" placeholder="Contoh: Kaur Umum, Sekretaris Desa" 
                       value="<?= $isEdit ? $stafEdit->jabatan : '' ?>"
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:5px;">

                <label>Email Login:</label>
                <input type="email" name="email" required value="<?= $isEdit ? $stafEdit->email : '' ?>" 
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:5px;">

                <label>No. HP:</label>
                <input type="text" name="hp" value="<?= $isEdit ? $stafEdit->no_hp : '' ?>" 
                       style="width: 100%; padding: 10px; margin-bottom: 15px; border:1px solid #ccc; border-radius:5px;">

                <div style="margin-bottom: 20px;">
                    <label>Password:</label>
                    
                    <?php if($isEdit): ?>
                        <div style="background: #fff3cd; padding: 10px; border: 1px solid #ffeeba; border-radius: 5px;">
                            <input type="checkbox" id="rpc" onchange="togglePass(this)">
                            <label for="rpc" style="display:inline; font-weight:normal; cursor:pointer;">
                                Centang untuk mereset password pengguna ini.
                            </label>
                            
                            <input type="text" name="password" id="pass_field" disabled 
                                   placeholder="Masukkan password baru di sini..." 
                                   style="width: 100%; padding: 8px; margin-top: 10px; border:1px solid #ccc; border-radius:5px;">
                        </div>
                        <script>
                            function togglePass(cb) {
                                document.getElementById('pass_field').disabled = !cb.checked;
                                if(cb.checked) document.getElementById('pass_field').focus();
                            }
                        </script>
                    <?php else: ?>
                        <input type="password" name="password" required placeholder="Buat password untuk login" 
                               style="width: 100%; padding: 10px; border:1px solid #ccc; border-radius:5px;">
                    <?php endif; ?>
                </div>

                <div style="text-align: right;">
                    <a href="index.php?page=manajemen_staf" style="margin-right: 15px; text-decoration: none; color:#666;">Batal</a>
                    <button type="submit" style="background: var(--primary-color); color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>