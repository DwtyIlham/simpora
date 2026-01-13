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
    <div class="col-md-12 col-sm-6">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex justify-content-between align-items-center ">
                <h5 class="card-title mb-0"><?= $title; ?></h5>
                <a href="<?= base_url('admin/operator/add'); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Operator</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-responsive table-bordered table-sm mb-0" id="dataTable" data-page-length='10' style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Nama</th>
                            <th scope="col" class="text-center">Sekolah</th>
                            <th scope="col" class="text-center">No. Whatsapp</th>
                            <th scope="col" class="text-center">Kecamatan</th>
                            <th scope="col" class="text-center">Tingkat</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data as $d):
                            $isActive = $d['isActive'] == '1' ? 'success' : 'danger';
                        ?>
                            <tr>
                                <td class="align-middle text-center"><?= $no; ?></td>
                                <td class="align-middle"><?= ucwords($d['nama']); ?></td>
                                <td class="align-middle"><?= $d['sekolah']; ?></td>
                                <td class="align-middle"><?= $d['kecamatan']; ?></td>
                                <td class="align-middle text-center"><?= $d['no_wa']; ?></td>
                                <td class="align-middle text-center"><?= $d['bentuk_pendidikan']; ?></td>
                                <td class="d-flex align-items-center gap-10 justify-content-center">
                                    <button type="button" data-id="<?= $d['id']; ?>" class="toggle-status-user bg-<?= $isActive; ?>-100 text-<?= $isActive; ?>-600 bg-hover-<?= $isActive; ?>-300 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Aktifkan / Non Aktifkan User">
                                        <iconify-icon icon="lucide:user-round-<?= $d['isActive'] == '1' ? 'check' : 'x'; ?>" class="menu-icon"></iconify-icon>
                                    </button>
                                    <button type="button" class="edit-users bg-warning-focus text-warning-600 bg-hover-warning-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                    <button type="button" id="<?= $d['id']; ?>" class="delete-operator remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
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
                <h5 class="modal-title" id="editModalLabel">Ubah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Form -->
                <form id="editForm" method="POST" action="<?= site_url('admin/users/update') ?>">
                    <input type="hidden" id="userId" name="id" />
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editName" name="nama" required />
                    </div>
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required />
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select class="form-select" id="editRole" name="role_id" required>
                            <option value="1">Administrator Dinas</option>
                            <option value="2">Operator Sekolah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="isActive" required>
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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

    // When the edit button is clicked
    document.querySelectorAll('.edit-users').forEach(button => {
        button.addEventListener('click', function() {
            // Get the user data from the clicked button's row
            const row = this.closest('tr');
            const userId = row.querySelector('.delete-operator').id;

            const userName = row.querySelector('td:nth-child(2)').textContent;
            const userUsername = row.querySelector('td:nth-child(3)').textContent;
            const userStatus = row.querySelector('td:nth-child(4) .bg-success-focus, td:nth-child(4) .bg-warning-focus').textContent.trim() === 'Aktif' ? '1' : '0';
            const userRole = row.querySelector('td:nth-child(5)').textContent.includes('Administrator') ? '1' : '2';

            // Populate the modal fields
            document.getElementById('userId').value = userId;
            document.getElementById('editName').value = userName;
            document.getElementById('editUsername').value = userUsername;
            document.getElementById('editStatus').value = userStatus;
            document.getElementById('editRole').value = userRole;

            // Show the modal
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });
</script>


<script>
    let table = new DataTable('#dataTable');

    // delete user
    const deleteButtons = document.querySelectorAll('.delete-operator');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const operatorID = this.id;
            swal.fire({
                title: "Yakin Hapus ?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#93999fff',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // redirect to delete route
                    window.location.href = `<?= base_url('admin/operator/delete/'); ?>${operatorID}`;
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>