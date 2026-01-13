<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Piagam Penghargaan</title>
</head>

<style>
  @page {
    size: A4 landscape;
    margin: 0;
  }

  /* * {
      border: 1px solid black;
    } */

  body {
    margin: 0;
    padding: 0;
    font-family: "Times New Roman", serif;
  }

  h1,
  h2,
  h3,
  h4,
  h5 {
    margin: 0;
  }

  .certificate {
    width: 297mm;
    height: 210mm;
    background: #ffffff;
    position: relative;

    background-image: url('<?= base_url('assets/images/bg-piagam.png'); ?>');
    background-size: cover;
    background-repeat: no-repeat;
    /* pola minimalis */
    /* background-image: linear-gradient(120deg, */
    /* rgba(0, 0, 0, 0.03) 25%,
        transparent 25%),
      linear-gradient(300deg, rgba(0, 0, 0, 0.03) 25%, transparent 25%);
    background-size: 40px 40px; */
  }

  .border {
    position: absolute;
    top: 5mm;
    left: 5mm;
    right: 5mm;
    bottom: 5mm;
    border: 5px solid #d4af37;
    border-radius: 5px;
  }

  .content {
    position: relative;
    text-align: center;
    padding: 10mm 15mm;
    margin-top: 5mm;
  }

  .logo {
    width: 70px;
    height: auto;
    display: block;
    margin: 0 auto 5px;
  }

  .title {
    font-size: 30px;
    font-weight: bold;
    margin: 5px 0;
  }

  .nomor {
    margin: -5px 0 10px 0;
    font-size: 14px;
  }

  .data {
    text-align: left;
    margin: 15px auto 10px auto;
    font-size: 17px;
  }

  .data td {
    padding: 3px 6px;
  }

  .ornament {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 12px 0;
  }

  .ornament span {
    width: 120px;
    height: 3px;
    background: #2c3e50;
  }

  .ornament .dot {
    width: 16px;
    height: 16px;
    background: #2c3e50;
    border-radius: 50%;
    margin: 0 10px;
  }

  .desc {
    font-size: 16px;
    max-width: 650px;
    line-height: 1.35;
    margin: 0 auto;
  }

  .tanggal {
    margin-top: 20px;
    font-size: 16px;
  }

  .ttd-wrapper {
    margin-top: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 25mm;
  }

  .ttd {
    text-align: center;
  }

  .sign {
    width: 100px;
    height: auto;
    margin: 5px auto;
  }

  .nama-pejabat {
    font-weight: bold;
    margin-top: -5px;
    font-size: 15px;
  }

  .nip {
    margin-top: -8px;
    font-size: 14px;
  }

  .qr img {
    position: absolute;
    z-index: 9999;
    left: 5%;
    top: 30%;
    width: 90px;
    height: auto;
    pointer-events: none;
    /* Optional: prevents blocking clicks */
  }
</style>

<body>
  <div class="certificate">
    <!-- BORDER EMAS -->
    <div class="border"></div>

    <!-- KONTEN UTAMA -->
    <div class="content">
      <!-- HEADER -->
      <img src="<?= base_url('assets/images/logo_bna.webp'); ?>" alt="Logo" class="logo" />

      <h2>PEMERINTAH KABUPATEN BANJARNEGARA</h2>
      <h3>DINAS PENDIDIKAN, KEPEMUDAAN DAN OLAHRAGA</h3>

      <h1 class="title">PIAGAM PENGHARGAAN</h1>
      <p class="nomor">Nomor: xxx.xxx.xxx.2025</p>

      <span>Diberikan Kepada:</span>

      <!-- QR CODE -->
      <div class="qr">
        <!-- <img src="<?= base_url('assets/images/dummy-qr.webp'); ?>" alt="QR Code" /> -->
        <img src="<?= $qrUrl ?>" alt="QR Code" />
      </div>

      <!-- DATA PENERIMA -->
      <table class="data">
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td><?= $data['atlet_nama']; ?></td>
        </tr>
        <tr>
          <td>Sekolah</td>
          <td>:</td>
          <td><?= $data['sekolah_nama']; ?></td>
        </tr>
        <tr>
          <td>Sebagai</td>
          <td>:</td>
          <td>Juara <?= $data['prestasi']; ?> Cabang Olahraga <?= $data['cabor_nama']; ?></td>
        </tr>
      </table>

      <!-- GARIS DEKORASI -->
      <div class="ornament">
        <span></span><span class="dot"></span><span></span>
      </div>

      <!-- BODY TEXT -->
      <p class="desc">
        Pada Pekan Olahraga Pelajar Daerah (POPDA) Tingkat Kabupaten
        Banjarnegara Tahun 2025<br />yang diselenggarakan pada tanggal 12 Februari
        2025 di Banjarnegara.
      </p>

      <p class="tanggal">Banjarnegara, 12 Februari 2025</p>

      <!-- TTD -->
      <div class="ttd-wrapper">
        <div class="ttd">
          <p>
            Kepala Dinas Pendidikan, Kepemudaan dan Olahraga<br />Kabupaten
            Banjarnegara
          </p>

          <!-- TTD DIGITAL -->
          <img style="margin-top: -5px;" src="<?= base_url('assets/images/dummy-qr.webp'); ?>" alt="Tanda Tangan Digital" class="sign" />

          <p class="nama-pejabat">Nama Kepala Dinas</p>
          <p class="nip">NIP. 19xxxxxxxxxxxxxxxx</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>