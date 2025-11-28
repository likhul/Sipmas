<?php
// Pastikan $detail sudah tersedia dari controller. 
// Jika diakses langsung tanpa controller, kode ini akan error, tapi karena lewat index.php aman.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - <?= $detail->nomor_tiket ?></title>
    <style>
        /* --- RESET & BASIC --- */
        @page { size: A4; margin: 0; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #eee; /* Abu-abu di luar kertas */
            -webkit-print-color-adjust: exact;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 25mm; /* Margin Kertas Standar */
            margin: 10mm auto;
            background: white;
            position: relative;
            box-sizing: border-box;
        }

        /* --- KOP SURAT (FLEXBOX) --- */
        .kop-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px;
            border-bottom: 3px double #000;
            padding-bottom: 5px;
        }

        .kop-kiri { width: 100px; text-align: left; }
        .kop-kiri img { width: 80px; height: auto; }
        
        .kop-tengah { 
            flex: 1; 
            text-align: center; 
            line-height: 1.2; 
        }
        .kop-tengah h3 { margin: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; }
        .kop-tengah h2 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-tengah p { margin: 0; font-size: 10pt; font-style: italic; }

        .kop-kanan { width: 100px; } /* Penyeimbang */

        /* --- JUDUL --- */
        .judul { text-align: center; margin-top: 30px; margin-bottom: 30px; }
        .judul u { font-size: 14pt; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .judul span { font-size: 12pt; }

        /* --- ISI & BIODATA --- */
        .isi-surat { text-align: justify; line-height: 1.5; }
        
        .biodata {
            margin-left: 20px; margin-top: 10px; margin-bottom: 10px;
            width: 95%; border-collapse: collapse;
        }
        .biodata td { vertical-align: top; padding: 2px 0; font-size: 12pt; }
        .label-col { width: 170px; }
        .sep-col { width: 15px; text-align: center; }

        /* --- TANDA TANGAN (FIX POSISI & BARIS) --- */
        .ttd-wrapper {
            width: 100%;
            margin-top: 50px;
            display: flex;
            justify-content: flex-end; /* Dorong ke kanan */
        }

        .ttd-box {
            width: 300px;
            text-align: center;
            /* Gunakan Flex Column agar elemen pasti turun ke bawah */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .ttd-text {
            margin: 0;
            line-height: 1.5;
            display: block; /* Pastikan block */
            width: 100%;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-top: 10px;
        }
        
        /* Kotak QR */
        .qr-img {
            margin: 10px auto;
            width: 100px;
            height: 100px;
            display: block;
        }

        /* Disclaimer Kecil */
        .disclaimer {
            font-size: 8pt; 
            font-style: italic; 
            color: #555; 
            margin-top: 5px; 
            line-height: 1.1;
        }

        /* --- MODE CETAK --- */
        .no-print { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .btn { background: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 5px; }
        
        @media print {
            body { background-color: white; }
            .page { margin: 0; padding: 20mm 25mm; box-shadow: none; border: none; width: 100%; height: auto; }
            .no-print { display: none; }
            @page { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <a href="javascript:window.print()" class="btn" style="background: #28a745;">🖨 Cetak</a>
        <a href="javascript:window.close()" class="btn" style="background: #dc3545;">Tutup</a>
    </div>

    <div class="page">
        
        <div class="kop-container">
            <div class="kop-kiri">
                <img src="assets/images/logo.png" alt="Logo" onerror="this.style.display='none'">
            </div>
            <div class="kop-tengah">
                <h3>PEMERINTAH KABUPATEN MUARO JAMBI</h3>
                <h3>KECAMATAN JAMBI LUAR KOTA</h3>
                <h2>PEMERINTAH DESA SIMPANG SUNGAI DUREN</h2>
                <p>Alamat: Jl. Jambi - Ma. Bulian KM 17, Simpang Sungai Duren, Kode Pos: 36361</p>
            </div>
            <div class="kop-kanan"></div>
        </div>

        <div class="judul">
            <u><?= strtoupper($detail->nama_layanan) ?></u>
            <span>Nomor : <?= $detail->nomor_surat_resmi ?? '___ / ___ / ___ / ____' ?></span>
        </div>

        <div class="isi-surat">
            <p>Yang bertanda tangan di bawah ini Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa:</p>

            <?php $info = json_decode($detail->data_pengaju, true); ?>

            <table class="biodata">
                <tr>
                    <td class="label-col">Nama Lengkap</td> <td class="sep-col">:</td>
                    <td><strong><?= strtoupper($detail->nama_lengkap) ?></strong></td>
                </tr>
                <tr>
                    <td class="label-col">NIK</td> <td class="sep-col">:</td>
                    <td><?= $detail->nik ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="label-col">Jenis Kelamin</td> <td class="sep-col">:</td>
                    <td>Laki-laki / Perempuan</td> 
                </tr>
                <tr>
                    <td class="label-col">Agama</td> <td class="sep-col">:</td>
                    <td>Islam</td> 
                </tr>
                <tr>
                    <td class="label-col">Pekerjaan</td> <td class="sep-col">:</td>
                    <td>Wiraswasta / Pelajar / Mahasiswa</td>
                </tr>
                <tr>
                    <td class="label-col">Alamat</td> <td class="sep-col">:</td>
                    <td><?= $detail->alamat ?></td>
                </tr>
                <tr>
                    <td class="label-col" style="padding-top: 5px;">Keperluan</td>
                    <td class="sep-col" style="padding-top: 5px;">:</td>
                    <td style="padding-top: 5px;"><strong><?= $info['keperluan'] ?? '-' ?></strong></td>
                </tr>
            </table>

            <div style="margin-top: 15px; text-align: justify;">
                <?php 
                switch ($detail->kode_surat) {
                    case 'SKU': echo "<p>Benar nama tersebut di atas adalah penduduk asli Desa Simpang Sungai Duren dan berdasarkan pengamatan kami yang bersangkutan benar-benar <strong>memiliki usaha</strong> yang berlokasi di wilayah Desa kami.</p>"; break;
                    case 'SKD': echo "<p>Benar nama tersebut di atas adalah penduduk asli dan <strong>berdomisili / bertempat tinggal</strong> di Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi.</p>"; break;
                    case 'SKCK': echo "<p>Orang tersebut di atas adalah benar-benar warga kami dan sepanjang pengetahuan kami selama bermasyarakat <strong>berkelakuan baik</strong>, tidak pernah tersangkut perkara Pidana/Perdata.</p>"; break;
                    default: echo "<p>Benar nama tersebut di atas adalah penduduk asli / berdomisili di Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi.</p>"; break;
                }
                ?>
                <p>Surat keterangan ini diberikan untuk keperluan: <strong><?= $info['keperluan'] ?? '................' ?></strong>.</p>
            </div>

            <p>Demikian surat keterangan ini kami buat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="ttd-wrapper">
            <div class="ttd-box">
                <div class="ttd-text">
                    Simpang Sungai Duren, <?= date('d F Y', strtotime($detail->tgl_surat ?? 'now')) ?>
                </div>
                
                <div class="ttd-text">
                    Kepala Desa
                </div>
                
                <?php
                    $digitalSignature = md5($detail->nomor_surat_resmi . $detail->id);
                    $qrContent  = "DOKUMEN SAH - PEMERINTAH DESA SIMPANG SUNGAI DUREN\n";
                    $qrContent .= "Penandatangan : YUSNARDI (Kepala Desa)\n";
                    $qrContent .= "Jenis Surat   : " . strtoupper($detail->nama_layanan) . "\n";
                    $qrContent .= "Nomor Surat   : " . ($detail->nomor_surat_resmi ?? 'Draft') . "\n";
                    $qrContent .= "Nama Warga    : " . strtoupper($detail->nama_lengkap) . "\n";
                    $qrContent .= "Validasi Key  : " . substr($digitalSignature, 0, 10);
                    
                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($qrContent);
                ?>
                <img src="<?= $qrUrl ?>" alt="QR Validasi" class="qr-img">
                
                <div class="ttd-nama">YUSNARDI</div>

                <div class="disclaimer">
                    Dokumen ini telah ditandatangani secara elektronik. Sesuai UU ITE No. 11 Tahun 2008, dokumen ini sah dan berkekuatan hukum.
                </div>
            </div>
        </div>

    </div>

</body>
</html>