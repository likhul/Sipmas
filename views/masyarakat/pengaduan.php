<section>
    <div style="margin-bottom: 20px;">
        <a href="index.php?page=dashboard_warga" style="text-decoration: none; color: #666;">&larr; Kembali ke Dashboard</a>
    </div>
    <h2>Layanan Pengaduan & Saran</h2>
    
    <div class="card">
        <form action="index.php?action=kirim_pengaduan" method="POST">
            <label>Subjek:</label>
            <input type="text" name="subjek" required placeholder="Contoh: Jalan Rusak di RT 01">
            <label>Isi Pesan:</label>
            <textarea name="isi" rows="4" required style="width:100%"></textarea>
            <button type="submit" class="btn-primary" style="margin-top:15px; background: #fd7e14;">Kirim Laporan</button>
        </form>
    </div>
    
    <h3>Riwayat Pengaduan Saya</h3>
    <div class="card">
        <ul style="list-style: none; padding: 0;">
        <?php foreach($daftarPengaduan as $p): ?>
            <li style="border-bottom:1px solid #eee; padding:15px 0;">
                <strong><?= $p->subjek ?></strong> <small style="color:#888;">(<?= date('d/m/Y', strtotime($p->created_at)) ?>)</small><br>
                <p style="margin: 5px 0; color:#555;"><?= $p->isi_pengaduan ?></p>
                <span class="badge" style="background: #eee; color: #333;"><?= $p->status ?></span>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</section>