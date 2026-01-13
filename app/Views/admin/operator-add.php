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
        <li class="fw-medium">SIMPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= base_url('admin/operator/data'); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Operator</a>
            </div>
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= $title; ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/operator/add'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="role" value="2">
                    <div class="row">
                        <div class="col-12 icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mage:user"></iconify-icon>
                            </span>
                            <select name="sekolah_id" id="sekolah" class="select2 form-select" data-placeholder="Pilih Sekolah" required>
                                <option></option>
                                <?php foreach ($sekolah as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= $s['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 icon-field mb-16">
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mage:whatsapp"></iconify-icon>
                                </span>
                                <input type="text" name="no_wa" class="form-control" value="<?= old('no_wa'); ?>" placeholder="Masukkan Nomor Whatsapp (08xxx)" required>
                            </div>
                        </div>
                        <div class="col-6 icon-field mb-16">
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mage:user"></iconify-icon>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6 icon-field mb-16">
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="mage:note-with-text"></iconify-icon>
                                </span>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6 position-relative mb-20">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                </span>
                                <input type="password" name="password" class="form-control radius-12" id="your-password" placeholder="Password">
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                        </div>
                        <button type="submit" class="btn btn-primary text-sm btn-sm p-12 w-100 radius-12"><i class="ri ri-save-line"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of Form Users Operator Sekolah -->
    </div>
</div>

<script>
    // ================== Password Show Hide Js Start ==========
    function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    // Call the function
    initializePasswordToggle('.toggle-password');
</script>

<?= $this->endSection(); ?>