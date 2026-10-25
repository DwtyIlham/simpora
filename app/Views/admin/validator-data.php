<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    tr>td {
        vertical-align: middle;
    }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Data Pengguna</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Data Pengguna
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12 col-sm-6">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex justify-content-between align-items-center ">
                <h5 class="card-title mb-0">Data Pengguna Tersimpan</h5>
                <a href="<?= base_url('admin/users/add'); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Pengguna</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pengguna</th>
                            <th scope="col">Akun</th>
                            <th scope="col">Cabor</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <?php $no = 1;
                        foreach ($users as $u):
                            $isActive = $u['isActive'] == '1' ? 'success' : 'danger'; ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $u['nama']; ?></td>
                                <td><?= $u['username']; ?></td>
                                <td class="text-start"><?= $u['cabor'] ?? '-'; ?></td>
                                <td><?= $u['role_id'] == '1' ? 'Administrator Dinas' : ($u['role_id'] == '2' ? 'Operator Sekolah' : 'Validator Dinas') ?></td>
                                <td class="d-flex align-items-center gap-10 justify-content-center">
                                    <button type="button" data-id="<?= $u['id']; ?>" class="toggle-status-user bg-<?= $isActive; ?>-100 text-<?= $isActive; ?>-600 bg-hover-<?= $isActive; ?>-300 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Aktifkan / Non Aktifkan User">
                                        <iconify-icon icon="lucide:user-round-<?= $u['isActive'] == '1' ? 'check' : 'x'; ?>" class="menu-icon"></iconify-icon>
                                    </button>
                                    <button type="button"
                                        class="edit-users bg-warning-focus text-warning-600 bg-hover-warning-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                        data-id="<?= $u['id']; ?>"
                                        data-nama="<?= $u['nama']; ?>"
                                        data-username="<?= $u['username']; ?>"
                                        data-cabor="<?= $u['cabor_id']; ?>"
                                        data-role="<?= $u['role_id']; ?>"
                                        data-status="<?= $u['isActive']; ?>"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Cabang Olahraga Validator">

                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                    <button type="button" id="<?= $u['id']; ?>" class="delete-user remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Cabang Olahraga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Form -->
                <div class="mb-3">
                    <input type="hidden" id="userId">
                    <label class="form-label">Tambah Cabor</label>

                    <div class="d-flex gap-2">
                        <select class="form-select" id="selectCabor">
                            <option value="">- Pilih Cabor -</option>
                        </select>

                        <button type="button" id="btnAddCabor" class="btn btn-success">
                            <iconify-icon icon="lucide:plus"></iconify-icon>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cabor Terpilih</label>
                    <div id="selectedCaborList" class="d-flex flex-column gap-2 m-auto"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // tombol edit
    $(document).on('click', '.edit-users', function() {
        let btn = $(this);
        let userId = btn.data('id');

        $('#userId').val(userId);
        $('#editName').val(btn.data('nama'));
        $('#editUsername').val(btn.data('username'));
        $('#editCabor').val(btn.data('cabor')).trigger('change');
        $('#editStatus').val(btn.data('status')).trigger('change');

        loadCabor();
        loadValidatorCabor(userId);

        let modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });

    function loadCabor() {
        $.ajax({
            url: "<?= site_url('admin/getCabor'); ?>",
            method: "GET",
            dataType: "json",
            success: function(res) {
                let html = '<option value="">- Pilih Cabor -</option>';
                res.forEach(c => {
                    html += `<option value="${c.id}">${c.nama}</option>`;
                });
                $('#selectCabor').html(html);
            }
        });
    }

    function loadValidatorCabor(userId) {
        $.ajax({
            url: "<?= site_url('admin/getValidatorCabor'); ?>",
            method: "POST",
            data: {
                user_id: userId
            },
            dataType: "json",
            success: function(res) {
                renderCaborList(res);
            }
        });
    }

    function renderCaborList(data) {
        let html = '';

        if (data.length === 0) {
            html = '<small class="text-muted">Belum ada cabor</small>';
        } else {
            data.forEach(c => {
                html += `
                <div class="d-flex justify-content-between align-items-center border rounded p-2">
                    <span>${c.nama}</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-danger btnDeleteCabor" data-id="${c.id}">
                            <iconify-icon icon="lucide:trash-2"></iconify-icon>
                        </button>
                    </div>
                </div>
            `;
            });
        }

        $('#selectedCaborList').html(html);
    }

    $(document).on('click', '#btnAddCabor', function() {
        let caborId = $('#selectCabor').val();
        let userId = $('#userId').val();

        if (!caborId) return alert('Pilih cabor dulu');

        $.ajax({
            url: "<?= site_url('admin/addValidatorCabor'); ?>",
            method: "POST",
            data: {
                user_id: userId,
                cabor_id: caborId
            },
            success: function() {
                loadValidatorCabor(userId);
            }
        });
    });

    $(document).on('click', '.btnDeleteCabor', function() {
        let caborId = $(this).data('id');
        let userId = $('#userId').val();

        $.ajax({
            url: "<?= site_url('admin/deleteValidatorCabor'); ?>",
            method: "POST",
            data: {
                user_id: userId,
                cabor_id: caborId
            },
            success: function() {
                loadValidatorCabor(userId);
            }
        });
    });
</script>


<script>
    let table = new DataTable('#dataTable');

    $('#dataTable').on('click', '.delete-user', function() {
        const userId = this.id;

        Swal.fire({
            title: "Yakin Hapus Pengguna?",
            text: "Data pengguna yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#93999fff',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= base_url('admin/users/delete/'); ?>${userId}`;
            }
        });
    });

    $(document).on('click', '.toggle-status-user', function() {
        let userID = $(this).data('id');
        let status;
        // get status operator
        $.ajax({
            url: `<?= site_url('api/get-status-user'); ?>`,
            method: 'post',
            data: {
                userID: userID
            },
            success: function(res) {
                let status = res['isActive'] == '1' ? '0' : '1';
                Swal.fire({
                    title: 'Ganti Status Operator.',
                    text: 'Status Operator "' + res['nama'] + '" Akan Diubah Menjadi ' + (status == '1' ? 'Aktif' : 'Tidak Aktif') + ', Lanjutkan ?',
                    icon: 'info',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?= site_url('api/toggle-status-user'); ?>`,
                            method: 'post',
                            data: {
                                status: status,
                                userID: userID
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: 'Berhasil !',
                                    icon: 'success'
                                })
                                // Update the icon dynamically based on the new status
                                let icon = (status == '1') ? 'lucide:user-round-check' : 'lucide:user-round-x';

                                // Find the button with the matching data-id and update the icon
                                $('button[data-id="' + userID + '"] .menu-icon').attr('icon', icon);

                                // Optionally, you can update the button's background color or other classes as well
                                let button = $('button[data-id="' + userID + '"]');
                                if (status == '1') {
                                    status = 'success';
                                    button.removeClass('bg-danger-100 text-danger-600 bg-hover-danger-300').addClass('bg-' + status + '-100 text-' + status + '-600 bg-hover-' + status + '-300');
                                } else {
                                    status = 'danger';
                                    button.removeClass('bg-success-100 text-success-600 bg-hover-success-300').addClass('bg-' + status + '-100 text-' + status + '-600 bg-hover-' + status + '-300');
                                }
                            }
                        })
                    }
                })
            }
        })
    })
</script>

<?= $this->endSection(); ?>