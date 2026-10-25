<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Ubah Data Atlet Pelajar</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Ubah Data Atlet Pelajar
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a href="<?= base_url('sekolah/atlet/data'); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Atlet</a>
        </div>
        <div class="card-header">
            <h5 class="card-title mb-0">Form Unggah Berkas Atlet Pelajar - <?= $atlet['nama']; ?></h5>
        </div>
        <form action="<?= site_url('sekolah/atlet/edit-berkas/') . $atlet['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row gy-3">
                    <?= csrf_field(); ?>
                    <div class="row gy-3 mt-2">
                        <div class="text-md text-neutral-500 border-bottom">LAMPIRAN</div>

                        <!-- File tidak menggunakan old(), karena file tidak bisa direstore -->
                        <div class="col-6" style="display: none;">
                            <label class="form-label">Unggah KK (*)</label>
                            <input type="file" name="file_kk" class="form-control">
                            <?php if (!empty($atlet['file_kk'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_kk/') . $atlet['file_kk']; ?>" target="_blank"><span class="text-primary">KK <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah Akte (*)</label>
                            <input type="file" name="file_akte" class="form-control">
                            <?php if (!empty($atlet['file_akte'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_akte/') . $atlet['file_akte']; ?>" target="_blank"><span class="text-primary">Akte <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah NISN (*)</label>
                            <input type="file" name="file_nisn" class="form-control">
                            <?php if (!empty($atlet['file_nisn'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_nisn/') . $atlet['file_nisn']; ?>" target="_blank"><span class="text-primary">NISN <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah KTP/KIA/KK (*)</label>
                            <input type="file" name="file_ktp_kia_kk" class="form-control">
                            <?php if (!empty($atlet['file_ktp_kia_kk'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_ktp_kia_kk/') . $atlet['file_ktp_kia_kk']; ?>" target="_blank"><span class="text-primary">KTP/KIA/KK <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah Foto</label>
                            <input type="file" name="file_foto" class="form-control" accept="image/jpeg, image/png">
                            <?php if (!empty($atlet['file_foto'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_foto/') . $atlet['file_foto']; ?>" target="_blank"><span class="text-primary">Foto <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah Surat Keterangan (*)</label>
                            <input type="file" name="file_suket" class="form-control">
                            <?php if (!empty($atlet['file_suket'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_suket/') . $atlet['file_suket']; ?>" target="_blank"><span class="text-primary">Surat Keterangan <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Unggah Ijazah</label>
                            <input type="file" name="file_ijazah" class="form-control">
                            <?php if (!empty($atlet['file_ijazah'])): ?>
                                <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_ijazah/') . $atlet['file_ijazah']; ?>" target="_blank"><span class="text-primary">Ijazah <i class="ri-file-check-line"></i></span></a></small>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="mt-12">
                        <button type="submit" class="btn btn-primary-600 w-100"><i class="ri ri-save-line"></i> Unggah Berkas</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>