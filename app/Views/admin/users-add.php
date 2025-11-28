<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Tambah Pengguna</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Tambah Pengguna
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
                <a href="<?= base_url('admin/users/data'); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Pengguna</a>
            </div>
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Pengguna</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-12">
                        <label class="form-label">Pilih Role</label>
                        <span class="icon align-middle">
                            <i class="ri-admin-line"></i>
                        </span>
                        <div class="icon-field">
                            <select class="form-select" id="select-role">
                                <option selected disabled>- Pilih Role -</option>
                                <option value="1">Administrator Dinas</option>
                                <option value="2">Operator Sekolah</option>
                                <!-- <option value="3">Atlet</option> -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Users Administrator Dinas -->
        <div class="card mt-12 form-1 d-none">
            <div class="card-header">
                <span class="mb-0 fw-bold">Role Administrator Dinas</span>
            </div>
            <form action="<?= base_url('admin/users/add'); ?>" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="role" value="1">
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:person"></iconify-icon>
                                </span>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Username</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:textformat-abc"></iconify-icon>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Password</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:lock"></iconify-icon>
                                </span>
                                <input type="text" name="password" class="form-control" placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <button role="submit" class="btn btn-primary-600 w-100"><i class="ri-save-line"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End of Form Users Administrator Dinas -->

        <!-- Form Users Operator Sekolah -->
        <div class="card mt-12 form-2 d-none">
            <div class="card-header">
                <span class="mb-0 fw-bold">Role Operator Sekolah</span>
            </div>
            <form action="<?= base_url('admin/users/add'); ?>" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="role" value="2">
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-6">
                            <label class="form-label">Pilih Sekolah</label>
                            <div class="icon-field">
                                <select name="sekolah" id="sekolah" class="select2 form-select" data-placeholder="Pilih Sekolah">
                                    <option value=""></option>
                                    <?php foreach ($sekolah as $s): ?>
                                        <option value="<?= $s['id']; ?>"><?= $s['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:person"></iconify-icon>
                                </span>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Username</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:textformat-abc"></iconify-icon>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Password</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:lock"></iconify-icon>
                                </span>
                                <input type="text" name="password" class="form-control" placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Nomor Whatsapp (08xx)</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="f7:lock"></iconify-icon>
                                </span>
                                <input type="text" name="no_wa" class="form-control" placeholder="Masukkan Nomor Whatsapp (08xx)" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <button role="submit" class="btn btn-primary-600 w-100"><i class="ri-save-line"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End of Form Users Operator Sekolah -->
    </div>
</div>

<script>
    let table = new DataTable('#dataTable');
    const selectRole = document.getElementById('select-role');
    const form1 = document.querySelector('.form-1');
    const form2 = document.querySelector('.form-2');
    selectRole.addEventListener('change', function() {
        const selectedValue = this.value;

        if (selectedValue === '1') {
            form1.classList.remove('d-none');
            form2.classList.add('d-none');
        } else if (selectedValue === '2') {
            form2.classList.remove('d-none');
            form1.classList.add('d-none');
        } else {
            form1.classList.add('d-none');
            form2.classList.add('d-none');
        }
    });
</script>

<?= $this->endSection(); ?>