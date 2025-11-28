<section style="padding-top: 20px;">
    
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 25px;">
            <div>
                <h3 style="margin: 0; border: none; padding: 0; font-size: 1.5rem; color: var(--primary);">
                    📊 Laporan & Arsip
                </h3>
                <p style="margin: 8px 0 0; color: #666; font-size: 0.95rem;">
                    Filter periode tanggal untuk mencetak laporan rekapitulasi.
                </p>
            </div>
            
            <a href="index.php?page=dashboard_admin" class="btn-warning" style="text-decoration: none; border-radius: 8px; font-size: 0.9rem; padding: 10px 20px; display: flex; align-items: center; gap: 8px;">
                <span>&larr;</span> Kembali
            </a>
        </div>

        <form action="index.php" method="GET" target="_blank">
            <input type="hidden" name="page" value="cetak_laporan">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Dari Tanggal:</label>
                    <input type="date" name="tgl_awal" required value="<?= date('Y-m-01') ?>" 
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #f9f9f9;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Sampai Tanggal:</label>
                    <input type="date" name="tgl_akhir" required value="<?= date('Y-m-d') ?>" 
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #f9f9f9;">
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Status Surat:</label>
                <select name="status_filter" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; background: #f9f9f9;">
                    <option value="">-- Semua Status --</option>
                    <option value="selesai">Selesai / Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(26, 42, 71, 0.2); font-weight: 600;">
                🖨 Cetak Laporan PDF
            </button>
        </form>
    </div>
</section>