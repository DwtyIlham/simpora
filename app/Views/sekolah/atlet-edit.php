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
        <li class="fw-medium">SIMPORA</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Ubah Data Atlet Pelajar</h5>
        </div>
        <form action="<?= site_url('sekolah/atlet/edit/') . $atlet['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row gy-3">
                    <?= csrf_field(); ?>

                    <div class="col-6">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" class="form-control" value="<?= $atlet['sekolah']; ?>" readonly>
                        <input type="hidden" name="sekolah" id="sekolah" class="form-control" value="<?= $atlet['sekolah_id']; ?>" readonly>

                    </div>

                    <div class="col-6">
                        <label class="form-label">Pilih Cabor</label>
                        <div class="icon-field">
                            <select name="cabor" class="form-select select2" data-placeholder="Pilih Cabang Olahraga" required>
                                <option></option>
                                <?php foreach ($cabor as $c): ?>
                                    <option value="<?= $c['id']; ?>"
                                        <?= (old('cabor') == $c['id'] || $atlet['cabor_id'] == $c['id']) ? 'selected' : '' ?>>
                                        <?= $c['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">NIK(*)</label>
                        <div class="icon-field">
                            <input type="text" name="nik" class="form-control" maxlength="16" minlength="16"
                                value="<?= set_value('nik', old('nik') ?? $atlet['nik']); ?>" placeholder="Masukkan NIK" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">NISN(*)</label>
                        <div class="icon-field">
                            <input type="text" name="nisn" class="form-control" minlength="10" maxlength="10"
                                value="<?= set_value('nisn', old('nisn') ?? $atlet['nisn']); ?>" placeholder="Masukkan NISN" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Nama Lengkap Sesuai KK(*)</label>
                        <div class="icon-field">
                            <input type="text" name="nama" class="form-control"
                                value="<?= set_value('nama', old('nama') ?? $atlet['nama']); ?>" placeholder="Masukkan Nama" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Jenis Kelamin(*)</label>
                        <div class="icon-field">
                            <select class="form-select" name="jk" required>
                                <option selected disabled> - Pilih Jenis Kelamin - </option>
                                <option value="L" <?= (old('jk') == 'L' || $atlet['jenis_kelamin'] == 'L')  ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="P" <?= (old('jk') == 'P' || $atlet['jenis_kelamin'] == 'P')  ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tempat Lahir(*)</label>
                        <div class="icon-field">
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="<?= set_value('tempat_lahir', old('tempat_lahir') ?? $atlet['tempat_lahir']); ?>" placeholder="Masukkan Tempat Lahir" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tanggal Lahir(*)</label>
                        <div class="icon-field">
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="<?= set_value('tanggal_lahir', old('tanggal_lahir') ?? $atlet['tanggal_lahir']); ?>" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Alamat(*)</label>
                        <div class="icon-field">
                            <input type="text" name="alamat" class="form-control"
                                value="<?= set_value('alamat', old('alamat') ?? $atlet['alamat']); ?>" placeholder="Masukkan Alamat Rumah" required>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 mt-2">
                    <div class="text-md text-neutral-500 border-bottom">LAMPIRAN</div>

                    <!-- File tidak menggunakan old(), karena file tidak bisa direstore -->
                    <div class="col-6">
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
                        <label class="form-label">Unggah KTP/KIA (*)</label>
                        <input type="file" name="file_ktp_kia" class="form-control">
                        <?php if (!empty($atlet['file_ktp_kia'])): ?>
                            <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_ktp_kia/') . $atlet['file_ktp_kia']; ?>" target="_blank"><span class="text-primary">KTP/KIA <i class="ri-file-check-line"></i></span></a></small>
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
                        <label class="form-label">Unggah Ijazah</label>
                        <input type="file" name="file_ijazah" class="form-control">
                        <?php if (!empty($atlet['ijazah'])): ?>
                            <small> File Terunggah : <a href="<?= base_url('public/uploads/atlet/file_ijazah/') . $atlet['file_ijazah']; ?>" target="_blank"><span class="text-primary">Ijazah <i class="ri-file-check-line"></i></span></a></small>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="mt-12">
                    <button type="submit" class="btn btn-primary-600 w-100"><i class="ri ri-save-line"></i> Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>