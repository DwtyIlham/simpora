<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
  <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
  <ul class="d-flex align-items-center gap-2">
    <li class="fw-medium">
      <a href="<?= site_url('admin/kompetisi/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        <?= $title; ?>
      </a>
    </li>
    <li>-</li>
    <li class="fw-medium">SIMPORA</li>
  </ul>
</div>

<div class="card mt-12">
  <div class="card-header">
    <h5 class="card-title mb-0"><?= $title . ' : ' . $peserta['atlet_nama']; ?></h5>
  </div>
  <div class="card-body m-auto">
    <div class="idcard" style="text-align: center;">
      <!-- Header -->
      <div class="header d-flex align-items-center justify-content-between text-center">
        <img src="<?= base_url('public/assets/images/logo_bna.svg') ?>" class="logo img-fluid" />
        <div class="event fw-bold align-middle"><?= $peserta['kompetisi_nama']; ?></div>
        <img src="<?= base_url('public/assets/images/icon.png') ?>" class="logo img-fluid" style="filter: invert(1)" />
      </div>
      <!-- Foto -->
      <div class="foto-wrap text-center mt-24">
        <img src="<?= base_url('uploads/atlet/file_foto/' . $peserta['file_foto']) ?>" class="foto shadow-sm" />
      </div>

      <div class="role mt-12">ATLET</div>

      <!-- Nama -->
      <div class="nama fw-bold text-center mt-2">
        <?= $peserta['atlet_nama']; ?>
      </div>

      <!-- Sekolah -->
      <div class="sekolah text-center small text-muted mb-1">
        <?= $peserta['sekolah_nama']; ?>
      </div>

      <!-- Cabor -->
      <div class="cabor text-center small mb-2">
        Cabang Olahraga: <span class="fw-semibold"><?= $peserta['cabor_nama']; ?></span>
      </div>

      <!-- QR Code -->
      <img src="<?= base_url('public/assets/images/dummy-qr.webp') ?>" class="qrcode img-fluid" />

      <!-- Footer Bar -->
      <div class="footer"></div>
    </div>
  </div>
</div>

<style>
  .idcard {
    width: 8.5cm;
    height: 13.5cm;
    background: #ffffff;
    border-color: #002752;
    border: 1px;
    border-radius: 14px;
    padding: 10px 12px;
    position: relative;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
    overflow: hidden;
  }

  .header {
    background: linear-gradient(135deg, #003d86, #005fcb);
    color: #fff;
    padding: 10px 6px 14px;
    border-radius: 10px;
    height: 10vh;
  }

  .logo {
    width: 30px;
    left: 10px;
    top: 8px;
  }

  .event {
    font-size: 16px;
    line-height: 1.2;
  }

  .role {
    font-size: 12px;
    margin-top: -2px;
    letter-spacing: 0.3px;
  }

  .foto-wrap .foto {
    width: 3cm;
    height: 4cm;
    object-fit: cover;
    border-radius: 8px;
  }

  .nama {
    font-size: 17px;
    color: #002752;
  }

  .sekolah {
    font-size: 13px;
  }

  .cabor {
    font-size: 12px;
  }

  .qrcode {
    width: 112px;
    /* right: 14px; */
    bottom: 18px;
  }

  .footer {
    width: 100%;
    height: 10px;
    background: #003d86;
    position: absolute;
    bottom: 0;
    left: 0;
    border-radius: 0 0 12px 12px;
  }
</style>
<?= $this->endSection(); ?>