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
      position: relative;
      overflow: hidden;
      margin: 0 auto;
      page-break-inside: avoid;
      page-break-after: avoid;
      background:
        radial-gradient(circle at 0% 0%, rgba(30, 64, 175, 0.05) 0%, transparent 40%),
        radial-gradient(circle at 100% 100%, rgba(30, 64, 175, 0.05) 0%, transparent 40%),
        #ffffff;
    }

    /* ORNAMEN BACKGROUND: GUILLOCHE-INSPIRED PATTERN */
    .pattern-guilloche {
      position: absolute;
      inset: 0;
      z-index: 0;
      opacity: 0.5;
      background-image:
        repeating-linear-gradient(45deg, transparent, transparent 39px, rgba(147, 197, 253, 0.15) 40px, transparent 41px),
        repeating-linear-gradient(-45deg, transparent, transparent 39px, rgba(147, 197, 253, 0.15) 40px, transparent 41px);
    }

    /* Hilangkan pattern-overlay yang menyebabkan error di Dompdf */


    /* BINGKAI BERLAPIS ELEGAN */
    .frame-border {
      position: absolute;
      z-index: 5;
      pointer-events: none;
    }

    .border-1 {
      /* Garis Terluar */
      top: 8mm;
      left: 8mm;
      right: 8mm;
      bottom: 8mm;
      border: 1.5px solid #1e3a8a;
    }

    .border-2 {
      /* Garis Utama Tebal */
      top: 10.5mm;
      left: 10.5mm;
      right: 10.5mm;
      bottom: 10.5mm;
      border: 4px double #1e40af;
    }

    .border-3 {
      /* Garis Dalam Tipis */
      top: 15mm;
      left: 15mm;
      right: 15mm;
      bottom: 15mm;
      border: 0.5px solid #93c5fd;
    }

    /* ORNAMEN SUDUT MODERN */
    .corner-ornament {
      position: absolute;
      width: 40mm;
      height: 40mm;
      z-index: 6;
      border-color: #1e3a8a;
      border-style: solid;
    }

    .c-top-left {
      top: 10.5mm;
      left: 10.5mm;
      border-width: 6px 0 0 6px;
      border-image: linear-gradient(135deg, #1e3a8a, #60a5fa) 1;
    }

    .c-top-right {
      top: 10.5mm;
      right: 10.5mm;
      border-width: 6px 6px 0 0;
      border-image: linear-gradient(225deg, #1e3a8a, #60a5fa) 1;
    }

    .c-bottom-left {
      bottom: 10.5mm;
      left: 10.5mm;
      border-width: 0 0 6px 6px;
      border-image: linear-gradient(45deg, #1e3a8a, #60a5fa) 1;
    }

    .c-bottom-right {
      bottom: 10.5mm;
      right: 10.5mm;
      border-width: 0 6px 6px 0;
      border-image: linear-gradient(315deg, #1e3a8a, #60a5fa) 1;
    }

    /* WATERMARK LOGO */
    .watermark-bg {
      position: absolute;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      z-index: 1;
      opacity: 0.05;
      filter: grayscale(100%);
    }

    /* KONTEN UTAMA */
    .content {
      position: absolute;




      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 10;


      padding: 18mm 25mm;
      /* Dikembalikan agar kop tidak terlalu turun */
      text-align: center;
    }

    /* WADAH DALAM UNTUK SCALING */
    .inner-wrapper {
      width: 100%;
      height: 100%;
      position: relative;
      /* Memastikan konten di tengah secara vertikal jika dibutuhkan */
      display: table;
    }

    .vertical-center {
      display: table-cell;
      vertical-align: middle;
      padding-top: 10mm;
      /* Ruang untuk kop agar tidak terlalu nempel atas */
    }
  </style>
</head>

<body>
  <?php foreach ($data as $d): ?>
    <div class="certificate">
      <!-- ORNAMEN BACKGROUND -->
      <div class="pattern-guilloche" aria-hidden="true"></div>

      <!-- WATERMARK LOGO DI TENGAH -->
      <img src="<?= imageToBase64(FCPATH . ('assets/images/logo_bna.png')) ?>" class="watermark-bg" alt="Watermark">

      <!-- BINGKAI BERLAPIS -->
      <div class="frame-border border-1"></div>
      <div class="frame-border border-2"></div>

      <div class="frame-border border-3"></div>

      <!-- ORNAMEN SUDUT -->
      <div class="corner-ornament c-top-left"></div>
      <div class="corner-ornament who areop-right"></div>
      <div class="corner-ornament c-bottom-left"></div>
      <div class="corner-ornament c-bottom-right"></div>

      <div class="content">
        <div class="inner-wrapper">
          <div class="vertical-center">


















            <!-- KOP SURAT -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; border-bottom: 4px double #1e3a8a; padding-bottom: 8px;">
              <tr>
                <td style="width: 10%; text-align: left; vertical-align: middle;">
                  <img src="<?= imageToBase64(FCPATH . ('assets/images/logo_bna.png')) ?>" style="width: 60px; height: auto;" alt="Logo Banjarnegara">
                </td>
                <td style="width: 80%; text-align: center; vertical-align: middle;">
                  <h2 style="font-family: 'Times New Roman', serif; font-size: 19px; font-weight: bold; color: #1e3a8a; margin: 0; letter-spacing: 1.5px; text-transform: uppercase;">PEMERINTAH KABUPATEN BANJARNEGARA</h2>
                  <h1 style="font-family: 'Times New Roman', serif; font-size: 17px; font-weight: bold; color: #0f172a; margin: 2px 0 0 0; letter-spacing: 0.5px; text-transform: uppercase;">DINAS PENDIDIKAN, KEPEMUDAAN DAN OLAHRAGA</h1>
                  <p style="font-family: 'Arial', sans-serif; font-size: 10px; color: #475569; margin: 3px 0 0 0;">Jl. May Jend DI Panjaitan No. 57 Telp. (0286)-594846 Banjarnegara 53414</p>
                  <p style="font-family: 'Arial', sans-serif; font-size: 10px; color: #475569; margin: 1px 0 0 0;">https://dindikpora.banjarnegarakab.go.id | Email: dindikpora@banjarnegarakab.go.id</p>
                </td>
                <td style="width: 10%; text-align: right; vertical-align: middle;">
                  <img src="<?= imageToBase64(FCPATH . ('assets/images/logo_popda_2026.webp')) ?>" style="width: 90px; height: auto;" alt="Logo POPDA">
                </td>
              </tr>
            </table>








            <!-- JUDUL PIAGAM -->
            <div style="margin-top: 10px; position: relative;">
              <h1 style="font-family: 'Times New Roman', serif; font-size: 34px; font-weight: bold; color: #1e3a8a; margin: 0; letter-spacing: 4px; text-transform: uppercase;">PIAGAM PENGHARGAAN</h1>
              <div style="width: 250px; height: 2px; background: linear-gradient(to right, transparent, #1e3a8a, transparent); margin: 6px auto;"></div>
              <p style="font-family: 'Arial', sans-serif; font-size: 13px; font-weight: bold; color: #1e40af; margin: 4px auto; letter-spacing: 1px;">Nomor: 400.4.1/2955/Dikpora/<?= date('Y'); ?></p>
              <p style="font-family: 'Times New Roman', serif; font-size: 15px; color: #475569; margin: 10px 0 0 0; font-style: italic;">Diberikan Kepada:</p>
            </div>













            <!-- DATA IDENTITAS -->
            <div style="margin: 12px auto; width: 100%;">
              <h2 style="font-family: 'Times New Roman', serif; font-size: 28px; font-weight: bold; color: #0f172a; margin: 5px 0; border-bottom: 2px solid #e2e8f0; display: inline-block; padding: 0 40px 3px 40px; text-transform: uppercase;">
                <?= $d['nama'] = preg_replace('/[^a-zA-Z ]/', '', $d['nama'] ?? ''); ?>
              </h2>
              <p style="font-family: 'Arial', sans-serif; font-size: 14px; color: #334155; margin: 6px 0;">
                Asal Sekolah: <span style="font-weight: bold; font-style: italic;"><?= $d['sekolah_nama'] ?? ''; ?></span>
              </p>
              <div style="background: rgba(30, 58, 138, 0.04); padding: 8px 15px; border-radius: 8px; border: 1px solid rgba(30, 58, 138, 0.1); display: inline-block; margin-top: 3px;">
                <p style="font-family: 'Times New Roman', serif; font-size: 16px; color: #1e3a8a; margin: 0;">
                  Sebagai <strong>Juara <?= $d['prestasi'] ?? ''; ?></strong> Cabang Olahraga
                  <strong><?= ucwords(strtolower($d['cabor_nama'] ?? '')) . ' ' . ucwords(strtolower($d['nomor_lomba'] ?? '')); ?></strong>
                </p>
              </div>
            </div>

            <!-- TEKS DESKRIPSI EVENT -->
            <p style="font-family: 'Times New Roman', serif; font-size: 15px; max-width: 800px; line-height: 1.4; margin: 8px auto; text-align: center; color: #1e293b;">
              Pada Pekan Olahraga Pelajar Daerah (POPDA) Tingkat Kabupaten Banjarnegara Tahun <?= date('Y'); ?><br />
              yang diselenggarakan pada tanggal <?= isset($d['tgl_start']) ? tgl_indo($d['tgl_start']) : ''; ?> - <?= isset($d['tgl_end']) ? tgl_indo($d['tgl_end']) : ''; ?> bertempat di Banjarnegara.
            </p>








            <!-- BAGIAN TANDA TANGAN & QR -->
            <table style="width: 100%; margin-top: 15px; border-collapse: collapse;">
              <tr>
                <td style="width: 45%; text-align: left; vertical-align: bottom; padding-left: 5mm;">
                  <div style="border: 1px solid #cbd5e1; padding: 8px; background: #ffffff; border-radius: 6px; display: inline-block; max-width: 260px;">
                    <table style="width: 100%; border-collapse: collapse;">
                      <tr>
                        <td style="width: 55px;">
                          <img src="<?= $qrUrl ?? '' ?>" style="width: 50px; height: 50px; margin-right: 8px;" alt="QR" />
                        </td>
                        <td style="font-family: 'Arial', sans-serif; font-size: 8px; color: #64748b; line-height: 1.3; vertical-align: middle; text-align: left;">
                          <strong style="color: #1e3a8a; font-size: 9px;">VERIFIKASI SISTEM</strong><br>
                          Dokumen sah terverifikasi secara elektronik melalui sistem SILAGAPORA Dindikpora Banjarnegara.
                        </td>
                      </tr>
                    </table>
                  </div>
                </td>



                <td style="width: 55%; text-align: center; vertical-align: top; padding-right: 5mm;">
                  <p style="margin: 0; font-size: 15px; color: #0f172a; font-family: 'Times New Roman', serif; line-height: 1.3;">
                    Banjarnegara, <?= tgl_indo(date('Y-m-d')) ?><br>
                    <strong>Kepala Dinas Pendidikan, Kepemudaan<br>dan Olahraga Kabupaten Banjarnegara</strong>
                  </p>

                  <div style="height: 60px; margin: 2px 0;">
                    <!-- Tanda Tangan Space -->
                  </div>

                  <p style="font-weight: bold; font-size: 16px; color: #0f172a; margin: 0; font-family: 'Times New Roman', serif; text-decoration: underline;">
                    Yusuf Agung Prabowo, S.H., M.Si.
                  </p>
                  <p style="margin: 1px 0 0 0; font-size: 14px; color: #0f172a; font-family: 'Times New Roman', serif;">
                    Pembina Utama Muda<br>
                    NIP. 19721030 199703 1 003
                  </p>
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>
      <tr>
        <td style="width: 45%; text-align: left; vertical-align: bottom; padding-left: 10mm;">
          <div style="border: 1px solid #cbd5e1; padding: 10px; background: #ffffff; border-radius: 6px; display: inline-block;">
            <table style="width: 100%; border-collapse: collapse;">
              <tr>
                <td>
                  <img src="<?= $qrUrl ?? '' ?>" style="width: 60px; height: 60px; margin-right: 10px;" alt="QR" />
                </td>
                <td style="font-family: 'Arial', sans-serif; font-size: 9px; color: #64748b; line-height: 1.4; vertical-align: middle;">
                  <strong style="color: #1e3a8a; font-size: 10px;">VERIFIKASI SISTEM</strong><br>
                  Dokumen ini sah dan terverifikasi secara elektronik melalui sistem SILAGAPORA Dindikpora Banjarnegara.
                </td>
              </tr>
            </table>
          </div>
        </td>

        <td style="width: 55%; text-align: center; vertical-align: top; padding-right: 10mm;">
          <p style="margin: 0; font-size: 16px; color: #0f172a; font-family: 'Times New Roman', serif; line-height: 1.4;">
            Banjarnegara, <?= tgl_indo(date('Y-m-d')) ?><br>
            <strong>Kepala Dinas Pendidikan, Kepemudaan<br>dan Olahraga Kabupaten Banjarnegara</strong>
          </p>

          <div style="height: 70px; margin: 5px 0;">
            <!-- Tanda Tangan Space -->
          </div>

          <p style="font-weight: bold; font-size: 17px; color: #0f172a; margin: 0; font-family: 'Times New Roman', serif; text-decoration: underline;">
            Yusuf Agung Prabowo, S.H., M.Si.
          </p>
          <p style="margin: 2px 0 0 0; font-size: 15px; color: #0f172a; font-family: 'Times New Roman', serif;">
            Pembina Utama Muda<br>
            NIP. 19721030 199703 1 003
          </p>
        </td>
      </tr>
      </table>
    </div>
    </div>

    </div>
    </div>
  <?php endforeach; ?>
</body>

</html>