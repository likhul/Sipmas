<?php
$tglAwal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tglAkhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi - SIPMAS</title>
    <style>
        /* --- 1. HILANGKAN HEADER BROWSER --- */
        @page { size: A4; margin: 0; }
        
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11pt; 
            padding: 20mm; /* Margin kertas manual */
            margin: 0;
            background: white;
        }

        /* --- 2. LAYOUT LAPORAN --- */
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 5px 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 10pt; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        
        /* --- 3. TOMBOL CETAK --- */
        .no-print { margin-bottom: 20px; text-align: right; }
        .btn-print { background: #1a2a47; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; text-decoration: none; font-size: 14px;}
        .btn-close { color: red; text-decoration: none; margin-left: 10px; font-weight: bold; }

        @media print { 
            .no-print { display: none; } 
            body { padding: 20mm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <a href="javascript:window.print()" class="btn-print">🖨 Cetak / Simpan PDF</a>
        <a href="javascript:window.close()" class="btn-close">Tutup</a>
    </div>

    <div class="header">
        <h3>PEMERINTAH KABUPATEN MUARO JAMBI</h3>
        <h2>LAPORAN REKAPITULASI PELAYANAN SURAT DESA</h2>
        <p>Periode: <strong><?= date('d/m/Y', strtotime($tglAwal)) ?></strong> s/d <strong><?= date('d/m/Y', strtotime($tglAkhir)) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Nomor Tiket / Surat</th>
                <th style="width: 25%;">Nama Pemohon (NIK)</th>
                <th style="width: 20%;">Jenis Layanan</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($dataLaporan)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; font-style: italic; color: #666;">
                        Tidak ada data permohonan pada periode ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($dataLaporan as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($row->created_at)) ?></td>
                    <td>
                        <?= $row->nomor_surat_resmi ?? $row->nomor_tiket ?>
                    </td>
                    <td>
                        <strong><?= strtoupper($row->nama_lengkap) ?></strong><br>
                        <small>(<?= $row->nik ?>)</small>
                    </td>
                    <td><?= $row->nama_layanan ?></td>
                    <td style="text-align: center;">
                        <?= ucfirst(str_replace('_', ' ', $row->status)) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="float: right; margin-top: 50px; text-align: center; width: 200px;">
        <p>Jambi, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        <p>Kepala Desa</p>
        <br><br><br><br>
        <p style="text-decoration: underline; font-weight: bold;">YUSNARDI</p>
    </div>

</body>
</html>