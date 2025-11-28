<section id="profil-saya">
    <div style="max-width: 700px; margin: 0 auto;">
        <h2>Kelola Profil Akun</h2>
        
        <div class="card">
            <form action="index.php?action=update_profil" method="POST">
                
                <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                    <h3 style="margin-top: 0; color: var(--primary-color);">Data Pribadi</h3>
                    
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama" required value="<?= $user->nama_lengkap ?>"
                           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                    <label>Email (Untuk Login):</label>
                    <input type="email" name="email" required value="<?= $user->email ?>"
                           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                    <label>Nomor HP / WhatsApp:</label>
                    <input type="text" name="hp" value="<?= $user->no_hp ?>"
                           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

                    <label>Alamat:</label>
                    <textarea name="alamat" rows="3" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><?= $user->alamat ?></textarea>
                    
                    <?php if($user->role == 'masyarakat'): ?>
                        <label>NIK (Tidak dapat diubah):</label>
                        <input type="text" value="<?= $user->nik ?>" disabled
                               style="width: 100%; padding: 10px; background: #eee; border: 1px solid #ccc; border-radius: 5px; color: #666;">
                        <small style="color: #888;">Hubungi Admin jika ada kesalahan NIK.</small>
                    <?php endif; ?>
                </div>

                <div>
                    <h3 style="margin-top: 0; color: var(--accent-color);">Keamanan</h3>
                    <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                        ⚠ Biarkan kosong jika tidak ingin mengubah password.
                    </div>

                    <label>Password Baru:</label>
                    <input type="password" name="password" minlength="6" placeholder="******"
                           style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <a href="javascript:history.back()" style="margin-right: 15px; text-decoration: none; color: #666;">Batal</a>
                    <button type="submit" class="btn-primary" style="background: var(--primary-color); color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer;">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>