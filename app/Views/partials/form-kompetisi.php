<?php
/**
 * Partial: Form Kompetisi (Add/Edit)
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $title    -> Judul halaman
 *   $kompetisi -> Array data kompetisi (untuk edit), null/empty untuk add
 *   $formUrl  -> URL action form (POST)
 *   $backUrl  -> URL kembali ke daftar kompetisi
 */

?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Form Kompetisi'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Form Kompetisi'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <div>
        <a href="<?= esc($backUrl ?? base_url('admin/kompetisi/data')); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600 radius-8">
            <i class="ri-arrow-go-back-line"></i> Daftar Kompetisi
        </a>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= esc($title ?? 'Kompetisi'); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= esc($formUrl); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="row gy-2">
                        <div class="col-6">
                            <label class="form-label">Nama Kompetisi</label>
                            <div class="icon-field">
                                <span class="icon"><iconify-icon icon="carbon:event"></iconify-icon></span>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Kompetisi"
                                    value="<?= esc(set_value('nama', $kompetisi['nama'] ?? '')); ?>" autocomplete="off" required>
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
                            <label class="form-label">Deskripsi</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                placeholder="Masukkan Deskripsi Kompetisi"
                                value="<?= esc(set_value('deskripsi', $kompetisi['deskripsi'] ?? '')); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control"
                                placeholder="Masukkan Lokasi Kompetisi"
                                value="<?= esc(set_value('lokasi', $kompetisi['lokasi'] ?? '')); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_start" id="tgl_start" class="form-control"
                                value="<?= esc(set_value('tgl_start', $kompetisi['tgl_start'] ?? '')); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tgl_end" id="tgl_end" class="form-control"
                                value="<?= esc(set_value('tgl_end', $kompetisi['tgl_end'] ?? '')); ?>" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Akhir Pendaftaran</label>
                            <input type="date" name="tgl_reg_end" id="tgl_reg_end" class="form-control"
                                value="<?= esc(set_value('tgl_reg_end', $kompetisi['tgl_reg_end'] ?? '')); ?>" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-600 w-100">
                                <i class="ri-<?= !empty($kompetisi) ? 'edit' : 'save'; ?>-line"></i>
                                <?= !empty($kompetisi) ? ' Ubah' : ' Simpan' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
