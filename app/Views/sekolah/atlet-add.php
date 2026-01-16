<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Tambah Data Atlet Pelajar</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Tambah Data Atlet Pelajar
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SIMPORA</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <a onclick="history.back(-1)" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Atlet</a>
        </div>
        <div class="card-header">
            <h5 class="card-title mb-0">Form Tambah Data Atlet Pelajar</h5>
        </div>
        <form action="<?= site_url('sekolah/atlet/add'); ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row gy-3">
                    <?= csrf_field(); ?>

                    <div class="col-6">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" class="form-control" value="<?= $sekolah['nama']; ?>" readonly>
                        <input type="hidden" name="sekolah" id="sekolah" class="form-control" value="<?= $sekolah['id']; ?>" readonly>
                    </div>

                    <div class="col-6">
                        <label class="form-label">NIK(*)</label>
                        <input type="text" name="nik" class="form-control" maxlength="16" minlength="16"
                            value="<?= set_value('nik', old('nik') ?? @$atlet['nik']); ?>" placeholder="Masukkan NIK" autocomplete="off" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Pilih Cabor</label>
                        <select name="cabor" id="cabor" class="form-select select2" data-placeholder="Pilih Cabang Olahraga" required>
                            <option></option>
                            <?php foreach ($cabor as $c): ?>
                                <option value="<?= $c['id']; ?>"
                                    <?= (old('cabor') == $c['id'] || @$atlet['cabor_id'] == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">NISN(*)</label>
                        <input type="text" name="nisn" class="form-control" minlength="10" maxlength="10"
                            value="<?= set_value('nisn', old('nisn') ?? @$atlet['nisn']); ?>" placeholder="Masukkan NISN" autocomplete="off" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Nama Lengkap Sesuai KK(*)</label>
                        <input type="text" name="nama" class="form-control"
                            value="<?= set_value('nama', old('nama') ?? @$atlet['nama']); ?>" placeholder="Masukkan Nama" autocomplete="off" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Jenis Kelamin(*)</label>
                        <select class="form-select" name="jk" required>
                            <option selected disabled> - Pilih Jenis Kelamin - </option>
                            <option value="L" <?= (old('jk') == 'L' || @$atlet['jenis_kelamin'] == 'L')  ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="P" <?= (old('jk') == 'P' || @$atlet['jenis_kelamin'] == 'P')  ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tempat Lahir(*)</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="<?= set_value('tempat_lahir', old('tempat_lahir') ?? @$atlet['tempat_lahir']); ?>" placeholder="Masukkan Tempat Lahir" autocomplete="off" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tanggal Lahir(*)</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="<?= set_value('tanggal_lahir', old('tanggal_lahir') ?? @$atlet['tanggal_lahir']); ?>" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Alamat(*)</label>
                        <input type="text" name="alamat" class="form-control"
                            value="<?= set_value('alamat', old('alamat') ?? @$atlet['alamat']); ?>" placeholder="Masukkan Alamat Rumah" autocomplete="off" required>
                    </div>
                </div>

                <div class="row gy-4 mt-3">

                    <div class="col-12">
                        <h5 class="text-neutral-500 border-bottom">
                            LAMPIRAN <small class="text-muted">(Max. 2MB)</small>
                        </h5>
                    </div>

                    <!-- KK -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Unggah KK <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_kk" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp" required>
                        <?php if (!empty($atlet['file_kk'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-file-check-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_kk/' . $atlet['file_kk']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat KK
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- Akte -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Unggah Akte <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_akte" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp" required>
                        <?php if (!empty($atlet['file_akte'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-file-check-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_akte/' . $atlet['file_akte']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat Akte
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- NISN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Unggah NISN <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_nisn" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp" required>
                        <?php if (!empty($atlet['file_nisn'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-file-check-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_nisn/' . $atlet['file_nisn']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat NISN
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- KTP/KIA -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Unggah KTP / KIA <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_ktp_kia" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp" required>
                        <?php if (!empty($atlet['file_ktp_kia'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-file-check-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_ktp_kia/' . $atlet['file_ktp_kia']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat KTP/KIA
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- Foto -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Unggah Foto <span class="text-danger">*</span></label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_foto" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp" required>
                        <?php if (!empty($atlet['file_foto'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-image-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_foto/' . $atlet['file_foto']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat Foto
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- Ijazah -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Unggah Ijazah</label>
                        <small class="text-muted d-block mb-1">
                            JPG, JPEG, PNG, WEBP • 100KB - 2MB
                        </small>
                        <input type="file" name="file_ijazah" class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">
                        <?php if (!empty($atlet['file_ijazah'])): ?>
                            <small class="d-block mt-1">
                                <i class="ri-file-check-line text-success"></i>
                                <a href="<?= base_url('public/uploads/atlet/file_ijazah/' . $atlet['file_ijazah']); ?>"
                                    target="_blank" class="text-primary text-decoration-none">
                                    Lihat Ijazah
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="mt-12">
                    <button type="submit" class="btn btn-primary-600"><i class="ri ri-save-line"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let table = new DataTable('#dataTable');
</script>

<?= $this->endSection(); ?>