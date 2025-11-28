<?php
// AMBIL TANGGAL DARI URL (Perbaikan Error Undefined Variable)
$tglAwal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tglAkhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi - SIPMAS</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2, .header h3 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 10pt; }
        th { background-color: #f2f2f2; text-align: center; }
        .no-print { margin-bottom: 20px; text-align: right; }
        .btn-print { background: #1a2a47; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; text-decoration: none;}
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <a href="javascript:window.print()" class="btn-print">🖨 Cetak / Simpan PDF</a>
        <a href="javascript:window.close()" style="margin-left: 10px; color: red; text-decoration: none;">Tutup</a>
    </div>

    <div class="header">
        <h3>PEMERINTAH KABUPATEN MUARO JAMBI</h3>
        <h2>LAPORAN REKAPITULASI PELAYANAN SURAT DESA</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($tglAwal)) ?> s/d <?= date('d/m/Y', strtotime($tglAkhir)) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Nomor Tiket</th>
                <th style="width: 25%;">Nama Pemohon (NIK)</th>
                <th style="width: 20%;">Jenis Layanan</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($dataLaporan)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data pada periode ini.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($dataLaporan as $row): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($row->created_at)) ?></td>
                    <td><?= $row->nomor_tiket ?></td>
                    <td>
                        <?= $row->nama_lengkap ?><br>
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
        <p><strong>( BAPAK KEPALA DESA )</strong></p>
    </div>

</body>
</html>