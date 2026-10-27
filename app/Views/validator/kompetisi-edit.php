<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                <?= $title; ?>
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= $title; ?></h5>
            </div>
            <!-- Form kompetisi Administrator Dinas -->
            <form action="<?= site_url('validator/kompetisi/edit/') . $id ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row gy-2">
                        <div class="col-6">
                            <label class="form-label">Nama Kompetisi</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="carbon:event"></iconify-icon>
                                </span>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Kompetisi" value="<?= set_value('nama', $kompetisi['nama']); ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tingkat</label>
                            <select class="form-select" name="tingkat" id="tingkat">
                                <option value="">- Pilih Tingkat -</option>
                                <option value="kecamatan" <?= @$kompetisi['tingkat'] === 'kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
                                <option value="kabupaten" <?= @$kompetisi['tingkat'] === 'kabupaten' ? 'selected' : '' ?>>Kabupaten</option>
                                <option value="provinsi" <?= @$kompetisi['tingkat'] === 'provinsi' ? 'selected' : '' ?>>Provinsi</option>
                                <option value="nasional" <?= @$kompetisi['tingkat'] === 'nasional' ? 'selected' : '' ?>>Nasional</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Deskripsi</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi Kompetisi" value="<?= set_value('deskripsi', $kompetisi['deskripsi']); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Masukkan Lokasi Kompetisi" value="<?= set_value('lokasi', $kompetisi['lokasi']); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_start" id="tgl_start" class="form-control" placeholder="Masukkan Lokasi Kompetisi" value="<?= set_value('tgl_start', $kompetisi['tgl_start']); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tgl_end" id="tgl_end" class="form-control" placeholder="Masukkan Lokasi Kompetisi" value="<?= set_value('tgl_end', $kompetisi['tgl_end']); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Tanggal Akhir Pendaftaran</label>
                            <input type="date" name="tgl_reg_end" id="tgl_reg_end" class="form-control" placeholder="Masukkan Lokasi Kompetisi" value="<?= set_value('tgl_reg_end', $kompetisi['tgl_reg_end']); ?>" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <button role="submit" class="btn btn-primary-600 w-100"><i class="ri-<?= !empty($kompetisi) ? 'edit' : 'save'; ?>-line"></i> <?= !empty($kompetisi) ? ' Ubah' : ' Simpan' ?> </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End of Form kompetisi Administrator Dinas -->
    </div>
</div>

<?= $this->endSection(); ?>