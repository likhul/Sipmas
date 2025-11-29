<div class="login-wrapper">
    <div class="login-container">
        <h2 style="color: var(--primary-color); margin-bottom: 10px;">
            <?= (isset($_GET['mode']) && $_GET['mode'] == 'register') ? 'Pendaftaran Warga' : 'Selamat Datang' ?>
        </h2>
        <p style="color: #666; margin-bottom: 30px; font-size: 0.9rem;">Sistem Informasi Pelayanan Masyarakat (SIPMAS)</p>

        <?php if(isset($_GET['mode']) && $_GET['mode'] == 'register'): ?>
            <form action="index.php?action=register_process" method="POST" style="text-align: left;">
                <label>NIK (16 Digit):</label>
                <input type="text" name="nik" required pattern="\d{16}" placeholder="Contoh: 1571..." style="margin-bottom: 15px;">

                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" required placeholder="Sesuai KTP" style="margin-bottom: 15px;">

                <label>Email:</label>
                <input type="email" name="email" required placeholder="email@contoh.com" style="margin-bottom: 15px;">

                <label>Password:</label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" style="margin-bottom: 15px;">
                
                <button type="submit" style="width: 100%; margin-top: 20px; padding: 12px;">Daftar Sekarang</button>
            </form>
            
            <p style="margin-top: 20px; font-size: 0.9rem;">
                Sudah punya akun? <a href="index.php?page=auth" style="color: var(--accent-color); font-weight: bold; text-decoration: none;">Login di sini</a>
            </p>

        <?php else: ?>
            <form action="index.php?action=login_process" method="POST" style="text-align: left;">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Masukkan email terdaftar">
                
                <label>Password:</label>
                <input type="password" name="password" required placeholder="********">

                <button type="submit" style="width: 100%; margin-top: 20px; padding: 12px; font-size: 1rem;">Masuk Aplikasi</button>
            </form>

            <p style="margin-top: 25px; font-size: 0.9rem;">
                Belum punya akun? <a href="index.php?page=auth&mode=register" style="color: var(--accent-color); font-weight: bold; text-decoration: none;">Daftar Warga Baru</a>
            </p>
        <?php endif; ?>
    </div>
</div>

<script>
    const inputNIK = document.querySelector('input[name="nik"]');
    
    if(inputNIK) {
        inputNIK.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if(this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    }
</script>