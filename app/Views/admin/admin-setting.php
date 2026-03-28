<?php

use CodeIgniter\Database\BaseUtils;
use CodeIgniter\HTTP\SiteURI;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    .custom-switch {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .custom-switch input {
        position: relative;
        width: 50px;
        height: 26px;
        -webkit-appearance: none;
        background-color: #ccc;
        outline: none;
        border-radius: 50px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    .custom-switch input::before {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        background-color: #fff;
        /* Lingkaran putih */
        transition: transform 0.3s;
    }

    .custom-switch input:checked {
        background-color: #198754;
        /* Warna aktif hijau */
    }

    .custom-switch input:checked::before {
        transform: translateX(24px);
    }

    .custom-switch label {
        cursor: pointer;
        user-select: none;
        color: #212529;
    }
</style>

<?php $role = session('user')['role_id'] == '1' ? 'admin' : 'sekolah' ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <h6 class="fw-semibold mb-0">Data Atlet Pelajar</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= site_url('admin/atlet/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                <?= $title; ?>
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                Notifikasi
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= $title; ?></h5>
                <a href="<?= base_url($role . '/atlet/add'); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Atlet</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">No.</th>
                            <th class="text-center" scope="col">Nama</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($setting as $s): ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center">
                                    <?= $s['nama']; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="custom-switch text-center">
                                        <input
                                            type="checkbox"
                                            id="status-<?= $s['id']; ?>"
                                            class="toggle-status"
                                            data-id="<?= $s['id']; ?>"
                                            <?= $s['status'] == '1' ? 'checked' : ''; ?>>
                                        <label for="status-<?= $s['id']; ?>">
                                            <?= $s['status'] == '1' ? 'Aktif' : 'Tidak Aktif'; ?>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning">Edit</button>
                                    <button class="btn btn-danger">Hapus</button>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let table = new DataTable('#dataTable', {
        responsive: true
    });

    // fungsi update label
    function updateLabel(checkbox) {
        let label = checkbox.next('.form-check-label');

        if (checkbox.is(':checked')) {
            label.text('Aktif').removeClass('text-danger').addClass('text-success');
        } else {
            label.text('Tidak Aktif').removeClass('text-success').addClass('text-danger');
        }
    }

    function showToast(message, type = 'success') {
        let toastEl = document.getElementById('liveToast');

        // reset warna
        toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning');

        // set warna
        if (type === 'success') {
            toastEl.classList.add('bg-success');
        } else if (type === 'error') {
            toastEl.classList.add('bg-danger');
        } else {
            toastEl.classList.add('bg-warning');
        }

        // isi pesan
        toastEl.querySelector('.toast-body').textContent = message;

        // tampilkan toast
        let toast = new bootstrap.Toast(toastEl, {
            delay: 3000
        });
        toast.show();
    }

    $(document).on('change', '.toggle-status', function() {
        let checkbox = $(this);
        let id = checkbox.data('id');

        // simpan state awal (buat rollback)
        let originalState = !checkbox.is(':checked');

        // update label langsung (biar responsif)
        updateLabel(checkbox);

        $.ajax({
            url: "<?= site_url('api/toggle_admin_setting'); ?>",
            type: "POST",
            data: {
                id: id,
                status: checkbox.is(':checked') ? '1' : '0'
            },
            success: function(response) {
                let res = JSON.parse(response);

                if (res.success) {
                    updateLabel(checkbox);
                    showToast('Status berhasil diupdate', 'success');
                } else {
                    checkbox.prop('checked', originalState);
                    updateLabel(checkbox);

                    showToast('Gagal update status', 'error');
                }
            },
            error: function() {
                checkbox.prop('checked', originalState);
                updateLabel(checkbox);

                showToast('Terjadi kesalahan server', 'error');
            }
        });
    });

    // fungsi update label
    function updateLabel(checkbox) {
        checkbox.next('.form-check-label')
            .text(checkbox.is(':checked') ? 'Aktif' : 'Tidak Aktif');
    }
</script>
<?= $this->endSection(); ?>