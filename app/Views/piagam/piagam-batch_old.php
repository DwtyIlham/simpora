<?php

use function App\Controllers\format_tgl;
use function App\Controllers\tgl_indo;

// Siapkan jalur untuk logo watermark
$watermarkUrl = base_url('public/assets/images/logo.png');
function imageToBase64($path)
{
  if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
  }
  return '';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Piagam Penghargaan</title>
  <style>
    /* RESET & SETUP A4 LANDSCAPE */
    @page {
      size: A4 landscape;
      margin: 0;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      font-family: "Times New Roman", serif;
      background-color: #ffffff;
      color: #0f172a;
      -webkit-print-color-adjust: exact;
    }

    /* WADAH UTAMA - Tinggi diset 209mm untuk cegah phantom page break */
    .certificate {
      width: 297mm;
      height: 209mm;
      background: #ffffff;
      position: relative;
      background-image: url('<?= FCPATH . 'assets/images/bg-piagam.png'; ?>');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      overflow: hidden;
      margin: 0 auto;
      page-break-inside: avoid;
      page-break-after: avoid;
    }

    /* WATERMARK EFEK LINE VECTOR */
    .watermark-bg {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 380px;
      /* Sesuaikan ukuran logo */
      height: auto;
      z-index: 1;
      pointer-events: none;
      /* Mengubah JPEG menjadi siluet garis */
      mix-blend-mode: multiply;
      filter: grayscale(100%) contrast(200%) opacity(0.08);
    }

    /* BINGKAI GANDA */
    .border-outer {
      position: absolute;
      top: 9mm;
      left: 9mm;
      right: 9mm;
      bottom: 9mm;
      border: 3px solid #c5a059;
      border-radius: 6px;
      z-index: 2;
      pointer-events: none;
    }

    .border-inner {
      position: absolute;
      top: 11mm;
      left: 11mm;
      right: 11mm;
      bottom: 11mm;
      border: 1px solid #c5a059;
      border-radius: 4px;
      z-index: 2;
      pointer-events: none;
    }

    /* ORNAMEN SUDUT */
    .corner-element {
      position: absolute;
      width: 25px;
      height: 25px;
      border: 2px solid #c5a059;
      z-index: 3;
    }

    .corner-tl {
      top: 13mm;
      left: 13mm;
      border-right: none;
      border-bottom: none;
    }

    .corner-tr {
      top: 13mm;
      right: 13mm;
      border-left: none;
      border-bottom: none;
    }

    .corner-bl {
      bottom: 13mm;
      left: 13mm;
      border-right: none;
      border-top: none;
    }

    .corner-br {
      bottom: 13mm;
      right: 13mm;
      border-left: none;
      border-top: none;
    }

    /* KONTEN UTAMA - MENGGUNAKAN ABSOLUTE UNTUK CEGAH PAGE BREAK */
    .content {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 10;
      padding: 13mm 20mm;
      /* Padding diperkecil */
      text-align: center;
    }
  </style>
</head>

<body>
  <?php foreach ($data as $d): ?>
    <div class="certificate">
      <!-- WATERMARK LOGO DI TENGAH -->
      <!-- <img src="<?= $watermarkUrl ?>" class="watermark-bg" alt="Watermark"> -->

      <!-- BINGKAI -->
      <div class="border-outer"></div>
      <div class="border-inner"></div>
      <div class="corner-element corner-tl"></div>
      <div class="corner-element corner-tr"></div>
      <div class="corner-element corner-bl"></div>
      <div class="corner-element corner-br"></div>

      <div class="content">

        <!-- KOP SURAT (Margin bottom disesuaikan) -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; border-bottom: 3px double #0f172a; padding-bottom: 8px;">
          <tr>
            <td style="width: 12%; text-align: center; vertical-align: middle;">
              <img src="<?= imageToBase64(FCPATH . ('assets/images/logo_bna.png')) ?>" style="width: 55px; height: auto;" alt="Logo Banjarnegara">
            </td>
            <td style="width: 88%; text-align: center; vertical-align: middle; padding-right: 65px;">
              <h2 style="font-family: 'Times New Roman', serif; font-size: 19px; font-weight: bold; color: #0f172a; margin: 0; letter-spacing: 1px; text-transform: uppercase;">PEMERINTAH KABUPATEN BANJARNEGARA</h2>
              <h1 style="font-family: 'Times New Roman', serif; font-size: 17px; font-weight: bold; color: #0f172a; margin: 3px 0 0 0; letter-spacing: 0.5px; text-transform: uppercase;">DINAS PENDIDIKAN, KEPEMUDAAN DAN OLAHRAGA</h1>
              <p style="font-family: 'Arial', sans-serif; font-size: 12px; color: #475569; margin: 5px 0 0 0;">Jl. Dipayuda No. 14, Banjarnegara, Jawa Tengah 53411</p>
            </td>
            <td style="width: 12%; text-align: center; vertical-align: middle;">
              <img src="<?= imageToBase64(FCPATH . ('assets/images/logo.jpeg')) ?>" style="width: 65px; height: auto; border-radius:10%;" alt="Logo Silagapora">
            </td>
            <td style="width: 12%; text-align: center; vertical-align: middle;">
              <img src="<?= imageToBase64(FCPATH . ('assets/images/logo_popda_2026.webp')) ?>" style="width: 120px; height: auto;" alt="Logo POPDA">
            </td>
          </tr>
        </table>

        <!-- JUDUL PIAGAM -->
        <div style="margin-top: 10px;">
          <h1 style="font-family: 'Times New Roman', serif; font-size: 32px; font-weight: bold; color: #9a7b32; margin: 0; letter-spacing: 3px; text-transform: uppercase;">PIAGAM PENGHARGAAN</h1>
          <p style="font-family: 'Times New Roman', serif; font-size: 14px; color: #334155; margin: 4px 0 0 0; font-style: italic;">Nomor: 400.4.1/2955/Dikpora/<?= date('Y'); ?></p>
          <p style="font-family: 'Times New Roman', serif; font-size: 15px; color: #475569; margin: 12px 0 0 0; font-style: italic;">Diberikan Kepada:</p>
        </div>

        <!-- DATA IDENTITAS (Padding sel disesuaikan) -->
        <table style="margin: 10px auto; border-collapse: collapse; min-width: 580px; text-align: left;">
          <tr>
            <td style="font-family: 'Arial', sans-serif; font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px; padding: 4px 0; width: 140px; vertical-align: middle;">Nama Lengkap</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 16px; color: #475569; padding: 4px 10px; width: 20px; text-align: center; vertical-align: middle;">:</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 22px; font-weight: bold; color: #0f172a; padding: 3px 0; vertical-align: middle; border-bottom: 1px dashed #cbd5e1; font-variant: small-caps;"><?= $d['nama'] = preg_replace('/[^a-zA-Z ]/', '', $d['nama'] ?? ''); ?></td>
          </tr>
          <tr>
            <td style="font-family: 'Arial', sans-serif; font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px; padding: 6px 0; vertical-align: middle;">Asal Sekolah</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 16px; color: #475569; padding: 6px 10px; text-align: center; vertical-align: middle;">:</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 16px; font-weight: 500; color: #1e293b; padding: 5px 0; vertical-align: middle; font-style: italic;"><?= $d['sekolah_nama'] ?? ''; ?></td>
          </tr>
          <tr>
            <td style="font-family: 'Arial', sans-serif; font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px; padding: 6px 0; vertical-align: middle;">Sebagai</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 16px; color: #475569; padding: 6px 10px; text-align: center; vertical-align: middle;">:</td>
            <td style="font-family: 'Times New Roman', serif; font-size: 16px; font-weight: bold; color: #b45309; padding: 5px 0; vertical-align: middle;">
              Juara <?= $d['prestasi'] ?? ''; ?> Cabang Olahraga <?= ucwords(strtolower($d['cabor_nama'] ?? '')) . ' ' . ucwords(strtolower($d['nomor_lomba'] ?? '')); ?>
            </td>
          </tr>
        </table>

        <!-- ORNAMEN GARIS TENGAH -->
        <table style="margin: 8px auto; border-collapse: collapse;">
          <tr>
            <td style="width: 120px; border-bottom: 2px solid #c5a059; height: 0; padding: 0;"></td>
            <td style="width: 30px; text-align: center; padding: 0 10px; vertical-align: middle;">
              <span style="display: inline-block; width: 6px; height: 6px; background: #c5a059; transform: rotate(45deg);"></span>
            </td>
            <td style="width: 120px; border-bottom: 2px solid #c5a059; height: 0; padding: 0;"></td>
          </tr>
        </table>

        <!-- TEKS DESKRIPSI EVENT -->
        <p style="font-family: 'Times New Roman', serif; font-size: 16px; max-width: 780px; line-height: 1.4; margin: 0 auto; text-align: center; color: #334155;">
          Pada Pekan Olahraga Pelajar Daerah (POPDA) Tingkat Kabupaten Banjarnegara Tahun <?= date('Y'); ?><br />
          yang diselenggarakan pada tanggal <?= isset($d['tgl_start']) ? tgl_indo($d['tgl_start']) : ''; ?> - <?= isset($d['tgl_end']) ? tgl_indo($d['tgl_end']) : ''; ?> bertempat di Banjarnegara.
        </p>

        <!-- BAGIAN TANDA TANGAN & QR (Margin atas diperkecil) -->
        <table style="width: 100%; margin-top: 15px; border-collapse: collapse;">
          <tr>
            <td style="width: 50%; text-align: left; vertical-align: bottom; padding-left: 10mm;">
              <table style="border: 1px dashed #c5a059; padding: 8px; background: rgba(248, 250, 252, 0.9); font-size: 10px; max-width: 300px; font-family: 'Arial', sans-serif; color: #475569; border-radius: 4px;">
                <tr>
                  <td style="vertical-align: top; padding-right: 8px; width: 60px;">
                    <img src="<?= $qrUrl ?? '' ?>" style="width: 55px; height: 55px; border: 1px solid #cbd5e1; background: #ffffff; padding: 2px;" alt="QR Code Verifikasi Dokumen" />
                  </td>
                  <td style="vertical-align: top; text-align: left; line-height: 1.5;">
                    <strong style="color: #0f172a; font-size: 10px; display: block; margin-bottom: 2px; text-transform: uppercase;">VERIFIKASI ELEKTRONIK</strong>
                    Piagam ini benar-benar diterbitkan oleh Silagapora <span style="color: #0f172a; font-weight: bold;">Dinas Pendidikan, Kepemudaan dan Olahraga Kabupaten Banjarnegara</span>.
                  </td>
                </tr>
              </table>
            </td>

            <td style="width: 50%; text-align: center; vertical-align: top; padding-right: 10mm;">
              &nbsp;<br>
              <p style="margin: 0; font-size: 16px; color: #0f172a; font-family: 'Times New Roman', serif; line-height: 1.5;">
                Banjarnegara, 25 Juni 2026<br>
                <strong>Kepala Dinas Pendidikan, Kepemudaan<br>dan Olahraga Kabupaten Banjarnegara</strong>
              </p>

              <div style="height: 80px; margin: 4px 0; text-align: center;">
                <!-- <img src="<?= base_url('assets/images/dummy-qr.webp'); ?>" style="height: 55px; width: auto;" alt="Tanda Tangan Elektronik Validated" /> -->
              </div>

              <p style="font-weight: bold; font-size: 16px; color: #0f172a; margin: 0; font-family: 'Times New Roman', serif;">
                Yusuf Agung Prabowo, S.H., M.Si.<br />
                <span style="font-weight: normal; font-size: 16px;">Pembina Utama Muda</span>
              </p>
              <p style="margin: 2px 0 0 0; font-size: 14px; color: #475569; font-family: 'Times New Roman', serif;">
                NIP 19721030 199703 1 003
              </p>
            </td>
          </tr>
        </table>

      </div>
    </div>
  <?php endforeach; ?>
</body>

</html>