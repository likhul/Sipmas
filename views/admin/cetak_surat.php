<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - <?= $detail->nomor_tiket ?></title>
    <style>
        /* --- 1. SETTING HALAMAN --- */
        @page { 
            size: A4; 
            margin: 0;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            margin: 0; padding: 0;
            background-color: #eee; /* Warna latar belakang preview */
            -webkit-print-color-adjust: exact;
        }

        .page {
            width: 210mm;
            min-height: auto;
            padding: 15mm 25mm; 
            margin: 10mm auto;
            background: white;
            position: relative;
            box-sizing: border-box;
        }

        /* --- 2. KOP SURAT --- */
        .kop-container {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; margin-bottom: 5px; border-bottom: 3px double #000; padding-bottom: 5px;
        }
        .kop-kiri { width: 100px; text-align: left; }
        .kop-kiri img { width: 80px; height: auto; }
        
        .kop-tengah { flex: 1; text-align: center; line-height: 1.2; }
        .kop-tengah h3 { margin: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; }
        .kop-tengah h2 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-tengah p { margin: 0; font-size: 10pt; font-style: italic; }

        .kop-kanan { width: 50px; } 

        /* --- 3. JUDUL --- */
        .judul { text-align: center; margin-top: 20px; margin-bottom: 20px; }
        .judul u { font-size: 14pt; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 3px; }
        .judul span { font-size: 12pt; }

        /* --- 4. ISI & BIODATA --- */
        .isi-surat { text-align: justify; line-height: 1.4; }
        
        .biodata {
            margin-left: 20px; margin-top: 5px; margin-bottom: 5px; width: 98%;
            border-collapse: collapse;
        }
        .biodata td { vertical-align: top; padding: 2px 0; font-size: 12pt; }
        .label-col { width: 170px; }
        .sep-col { width: 15px; text-align: center; }
        
        p { margin: 5px 0; } 

        /* --- 5. TANDA TANGAN (Tata Letak Stabil) --- */
        .ttd-wrapper {
            width: 100%; margin-top: 30px; 
            display: flex; justify-content: flex-end;
            page-break-inside: avoid; /* Mencegah tanda tangan terpotong ke halaman lain */
        }
        .ttd-box { width: 300px; text-align: center; display: flex; flex-direction: column; align-items: center; }
        
        /* Class ini memaksa teks turun ke bawah */
        .ttd-text { display: block; width: 100%; margin-bottom: 2px; line-height: 1.2; font-size: 12pt; }
        
        .ttd-nama { 
            font-weight: bold; text-decoration: underline; text-transform: uppercase; 
            margin-top: 5px; display: block; font-size: 12pt;
        }
        
        .qr-img { width: 90px; height: 90px; margin: 5px auto; display: block; }
        
        .disclaimer { 
            font-size: 8pt; font-style: italic; color: #555; margin-top: 2px; line-height: 1; 
        }

        /* --- TOMBOL CETAK --- */
        .no-print { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .btn { background: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: Arial; font-size: 12px; margin-left: 5px; cursor: pointer; }
        
       @media print {
            body { 
                background-color: white; 
                padding: 10mm; /* Pastikan padding tetap ada saat print */
            }
            .page { 
                margin: 0; 
                padding: 0 10mm; /* Sesuaikan padding konten */
                box-shadow: none; 
                border: none; 
                width: 100%; 
                height: auto; 
            }
            .no-print { display: none; }
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
            <div class="kop-kiri"><img src="assets/images/logo.png" alt="Logo" onerror="this.style.display='none'"></div>
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
                    <td class="label-col">Tempat/Tgl Lahir</td> <td class="sep-col">:</td>
                    <td>
                        <?php 
                            if (!empty($detail->tempat_lahir)) {
                                echo $detail->tempat_lahir . ', ' . date('d-m-Y', strtotime($detail->tanggal_lahir));
                            } else {
                                echo '-'; 
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Jenis Kelamin</td> <td class="sep-col">:</td>
                    <td><?= $detail->jenis_kelamin ?? '-' ?></td> 
                </tr>
                <tr>
                    <td class="label-col">Agama</td> <td class="sep-col">:</td>
                    <td><?= $detail->agama ?? '-' ?></td> 
                </tr>
                <tr>
                    <td class="label-col">Status Perkawinan</td> <td class="sep-col">:</td>
                    <td><?= $detail->status_perkawinan ?? '-' ?></td> 
                </tr>
                <tr>
                    <td class="label-col">Pekerjaan</td> <td class="sep-col">:</td>
                    <td><?= $detail->pekerjaan ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="label-col">Alamat</td> <td class="sep-col">:</td>
                    <td><?= $detail->alamat ?></td>
                </tr>
                <tr>
                    <td class="label-col">Keperluan</td> <td class="sep-col">:</td>
                    <td><strong><?= $info['keperluan'] ?? '-' ?></strong></td>
                </tr>
            </table>

            <div style="margin-top: 10px;">
                <?php 
                switch ($detail->kode_surat) {
                    case 'SKU': 
                        echo "<p>Benar nama tersebut di atas adalah penduduk asli Desa Simpang Sungai Duren dan berdasarkan pengamatan kami yang bersangkutan benar-benar <strong>memiliki usaha</strong> yang berlokasi di wilayah Desa kami.</p>"; break;
                    case 'SKD': 
                        echo "<p>Benar nama tersebut di atas adalah penduduk asli dan <strong>berdomisili / bertempat tinggal</strong> di Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi.</p>"; break;
                    case 'SKCK': 
                        echo "<p>Orang tersebut di atas adalah benar-benar warga kami dan sepanjang pengetahuan kami selama bermasyarakat <strong>berkelakuan baik</strong>, tidak pernah tersangkut perkara Pidana/Perdata.</p>"; break;
                    case 'SKTM': 
                        echo "<p>Menerangkan bahwa orang tersebut di atas adalah benar warga Desa Simpang Sungai Duren yang tergolong dalam keluarga <strong>TIDAK MAMPU / MISKIN</strong>. Surat ini dibuat untuk keperluan pengurusan bantuan sosial.</p>"; break;
                    case 'LHR': 
                        echo "<p>Menerangkan bahwa telah lahir seorang anak di Desa Simpang Sungai Duren dari orang tua tersebut di atas. Surat ini dibuat untuk kelengkapan administrasi Kependudukan.</p>"; break;
                    case 'KMT': 
                        echo "<p>Menerangkan bahwa warga dengan nama tersebut di atas telah <strong>MENINGGAL DUNIA</strong> di Desa Simpang Sungai Duren. Surat ini diberikan sebagai bukti kematian untuk pengurusan administrasi.</p>"; break;
                    case 'NIKAH': 
                        echo "<p>Orang tersebut di atas adalah benar warga kami yang berstatus <strong>" . ($detail->status_perkawinan ?? 'Belum Kawin') . "</strong> dan akan melangsungkan pernikahan. Surat ini berlaku sebagai pengantar ke KUA setempat.</p>"; break;
                    case 'IZIN': 
                        echo "<p>Memberikan <strong>IZIN KERAMAIAN</strong> kepada yang bersangkutan untuk mengadakan acara di wilayah Desa Simpang Sungai Duren, dengan catatan tetap menjaga ketertiban.</p>"; break;
                    
                    default: 
                        echo "<p>Benar nama tersebut di atas adalah penduduk asli / berdomisili di Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi.</p>"; break;
                }
                ?>
                
                <p>Surat keterangan ini diberikan untuk keperluan: <strong><?= $info['keperluan'] ?? '................' ?></strong>.</p>
            </div>

            <?php if(!empty($info['keterangan'])): ?>
                <p>Keterangan Tambahan: <?= $info['keterangan'] ?></p>
            <?php endif; ?>

            <p>Demikian surat keterangan ini kami buat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="ttd-wrapper">
            <div class="ttd-box">
                <span class="ttd-text">Simpang Sungai Duren, <?= date('d F Y', strtotime($detail->tgl_surat ?? 'now')) ?></span>
                <span class="ttd-text">Kepala Desa</span>

                <?php
                    $digitalSignature = md5($detail->nomor_surat_resmi . $detail->id . date('YmdHis'));
                    $qrContent  = "DOKUMEN SAH - PEMERINTAH DESA SIMPANG SUNGAI DUREN\n";
                    $qrContent .= "------------------------------------------------\n";
                    $qrContent .= "Penandatangan : YUSNARDI (Kepala Desa)\n";
                    $qrContent .= "Jenis Surat   : " . strtoupper($detail->nama_layanan) . "\n";
                    $qrContent .= "Nomor Surat   : " . ($detail->nomor_surat_resmi ?? 'Draft') . "\n";
                    $qrContent .= "Tanggal       : " . date('d-m-Y', strtotime($detail->tgl_surat ?? 'now')) . "\n";
                    $qrContent .= "Nama Warga    : " . strtoupper($detail->nama_lengkap) . "\n";
                    $qrContent .= "Digital Sig   : " . substr($digitalSignature, 0, 16) . "...\n";
                    $qrContent .= "------------------------------------------------\n";
                    $qrContent .= "Validasi Online: https://sipmas-desa.rf.gd/cek?token=" . substr($digitalSignature, 0, 10);
                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrContent);
                ?>

                <img src="<?= $qrUrl ?>" alt="QR" class="qr-img">

                <span class="ttd-nama">YUSNARDI</span>
                
                <div class="disclaimer">
                    Dokumen ini telah ditandatangani secara elektronik. Sesuai UU ITE No. 11 Tahun 2008, dokumen ini sah dan berkekuatan hukum.
                </div>
            </div>
        </div>
    </div>
</body>
</html>