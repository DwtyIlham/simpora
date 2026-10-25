<?php
/**
 * Partial: Tabel Pengguna Standar
 * Digunakan oleh admin, validator, dan sekolah users-data.
 *
 * Variabel yang diharapkan:
 *   $users       -> Array data pengguna
 *   $canAdd      -> boolean (tampilkan tombol Tambah)
 *   $canEdit     -> boolean (tampilkan tombol Edit)
 *   $canDelete   -> boolean (tampilkan tombol Hapus)
 *   $canToggle   -> boolean (tampilkan toggle Aktif/Nonaktif)
 *   $addUrl      -> URL halaman tambah pengguna
 *   $updateUrl   -> URL update pengguna (POST)
 *   $deleteUrl   -> URL hapus pengguna (GET)
 *   $toggleStatusUrl -> URL toggle status (POST api/toggle-status-user)
 *   $getStatusUrl  -> URL get status (POST api/get-status-user)
 *   $showSekolah -> boolean (tampilkan kolom Sekolah, default admin/validator)
 *   $showWhatsapp -> boolean (tampilkan kolom WhatsApp, default admin/validator)
 *   $roleOptions -> Array opsi role untuk dropdown edit (default admin & sekolah)
 */

use function App\Controllers\isAdmin;

$userRoleId = (string) (session('user')['role_id'] ?? '');
$role       = $userRoleId === '1' ? 'admin' : ($userRoleId === '4' ? 'validator' : 'sekolah');
$showSekolah  = $showSekolah ?? ($role === 'admin' || $role === 'validator');
$showWhatsapp = $showWhatsapp ?? ($role === 'admin' || $role === 'validator');
$canAdd       = $canAdd ?? true;
$canEdit      = $canEdit ?? true;
$canDelete    = $canDelete ?? true;
$canToggle    = $canToggle ?? ($role === 'admin');
$addUrl       = $addUrl ?? site_url('admin/users/add');
$updateUrl    = $updateUrl ?? site_url('admin/users/update');
$deleteUrl    = $deleteUrl ?? base_url('admin/users/delete/');
$toggleStatusUrl = $toggleStatusUrl ?? site_url('api/toggle-status-user');
$getStatusUrl    = $getStatusUrl ?? site_url('api/get-status-user');

$roleLabelMap = [
    '1' => 'Administrator Dinas',
    '2' => 'Operator Sekolah',
    '4' => 'Validator Dinas',
];

?>
<style>
    .user-table td { vertical-align: middle; }
    .user-action-group { gap: 4px; flex-wrap: nowrap; }
    .user-table-action {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }
    .user-table-action:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .12); }
</style>

<div class="row gy-4">
    <div class="col-md-12 col-sm-6">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Pengguna Tersimpan</h5>
                <?php if ($canAdd): ?>
                    <a href="<?= esc($addUrl); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Pengguna</a>
                <?php endif; ?>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered mb-0 user-table" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pengguna</th>
                            <th scope="col">Akun</th>
                            <?php if ($showSekolah): ?><th scope="col">Sekolah</th><?php endif; ?>
                            <?php if ($showWhatsapp): ?><th scope="col">Whatsapp</th><?php endif; ?>
                            <th scope="col">Role</th>
                            <?php if ($canToggle): ?><th class="text-center" scope="col">Status</th><?php endif; ?>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <?php $no = 1;
                        foreach ($users as $u):
                            $isActive = $u['isActive'] == '1';
                            $activeClass = $isActive ? 'success' : 'danger';
                            $roleId   = (string) ($u['role_id'] ?? '');
                            $roleLabel = $roleLabelMap[$roleId] ?? 'Operator Sekolah';
                            ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= esc($u['nama']); ?></td>
                                <td><?= esc($u['username']); ?></td>
                                <?php if ($showSekolah): ?><td><?= esc($u['sekolah'] ?? '-'); ?></td><?php endif; ?>
                                <?php if ($showWhatsapp): ?><td class="text-start"><?= esc($u['no_wa'] ?? '-'); ?></td><?php endif; ?>
                                <td><?= esc($roleLabel); ?></td>
                                <?php if ($canToggle): ?>
                                    <td class="text-center">
                                        <button type="button"
                                            data-id="<?= esc($u['id']); ?>"
                                            class="toggle-status-user user-table-action bg-<?= $activeClass; ?>-100 text-<?= $activeClass; ?>-600 bg-hover-<?= $activeClass; ?>-300 fw-medium rounded-circle"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Aktifkan / Non Aktifkan User">
                                            <iconify-icon icon="lucide:user-round-<?= $isActive ? 'check' : 'x'; ?>" class="menu-icon"></iconify-icon>
                                        </button>
                                    </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <div class="user-action-group">
                                        <?php if ($canEdit): ?>
                                            <button type="button" class="edit-users user-table-action bg-warning-focus text-warning-600 bg-hover-warning-200 fw-medium rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Data Pengguna">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($canDelete): ?>
                                            <button type="button"
                                                id="<?= esc($u['id']); ?>"
                                                class="delete-user remove-item-btn user-table-action bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Pengguna">
                                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                            </button>
                                        <?php endif; ?>
                                    </div>
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
<?php if ($canEdit): ?>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Ubah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="<?= esc($updateUrl); ?>">
                    <?= csrf_field(); ?>
                    <input type="hidden" id="editUserId" name="id" />
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editUserName" name="nama" required />
                    </div>
                    <div class="mb-3">
                        <label for="editUserUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUserUsername" name="username" required />
                    </div>
                    <?php if ($role === 'admin'): ?>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select class="form-select" id="editUserRole" name="role_id" required>
                                <?php foreach ($roleOptions ?? ['1' => 'Administrator Dinas', '2' => 'Operator Sekolah', '4' => 'Validator Dinas'] as $rid => $rlabel): ?>
                                    <option value="<?= esc($rid); ?>"><?= esc($rlabel); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="editUserStatus" class="form-label">Status</label>
                        <select class="form-select" id="editUserStatus" name="isActive" required>
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
<?php endif; ?>

<script>
    $(function() {
        // Edit user: ambil data dari baris tabel
        document.querySelectorAll('.edit-users').forEach(function(button) {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.querySelector('.delete-user')?.id ?? '';

                const userName = row.querySelector('td:nth-child(2)')?.textContent.trim() ?? '';
                const userUsername = row.querySelector('td:nth-child(3)')?.textContent.trim() ?? '';

                let statusIdx = 4;
                let roleIdx = 5;
                if (<?= json_encode($showSekolah); ?>) statusIdx++;
                if (<?= json_encode($showWhatsapp); ?>) statusIdx++;
                const userStatus = row.querySelector('td:nth-child(' + statusIdx + ')')?.textContent.trim() === 'Aktif' ? '1' : '0';
                const userRole = row.querySelector('td:nth-child(' + roleIdx + ')')?.textContent.includes('Administrator') ? '1' : '2';

                document.getElementById('editUserId').value = userId;
                document.getElementById('editUserName').value = userName;
                document.getElementById('editUserUsername').value = userUsername;
                document.getElementById('editUserStatus').value = userStatus;
                if (document.getElementById('editUserRole')) {
                    document.getElementById('editUserRole').value = userRole;
                }

                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            });
        });

        // Delete user
        $('#dataTable').on('click', '.delete-user', function() {
            const userId = this.id;
            Swal.fire({
                title: 'Yakin Hapus Pengguna?',
                text: 'Data pengguna yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#93999fff',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= esc($deleteUrl); ?>' + userId;
                }
            });
        });

        // Toggle status user
        $(document).on('click', '.toggle-status-user', function() {
            const btn = $(this);
            const userID = btn.data('id');

            $.post('<?= esc($getStatusUrl); ?>', { userID: userID }, function(res) {
                const isActive = res?.isActive == '1';
                const newStatus = isActive ? '0' : '1';
                const nama = res?.nama ?? 'Pengguna';

                Swal.fire({
                    title: 'Ganti Status Pengguna.',
                    text: 'Status "' + nama + '" akan diubah menjadi ' + (newStatus == '1' ? 'Aktif' : 'Tidak Aktif') + ', lanjutkan?',
                    icon: 'info',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('<?= esc($toggleStatusUrl); ?>', { status: newStatus, userID: userID }, function(res) {
                            Swal.fire({ title: 'Berhasil!', icon: 'success' });
                            const newIcon = newStatus == '1' ? 'lucide:user-round-check' : 'lucide:user-round-x';
                            btn.find('.menu-icon').attr('icon', newIcon);
                            const newCls = newStatus == '1' ? 'success' : 'danger';
                            const oldCls = newStatus == '1' ? 'danger' : 'success';
                            btn.removeClass('bg-' + oldCls + '-100 text-' + oldCls + '-600 bg-hover-' + oldCls + '-300')
                               .addClass('bg-' + newCls + '-100 text-' + newCls + '-600 bg-hover-' + newCls + '-300');
                        });
                    }
                });
            });
        });

        let table = new DataTable('#dataTable');
    });
</script>
