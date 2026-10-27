<?php
/**
 * Partial: Tabel Cabor Standar
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $cabor       -> Array data cabor
 *   $title       -> Judul halaman
 *   $canAdd      -> boolean (tampilkan tombol Tambah)
 *   $canEdit     -> boolean (tampilkan tombol Edit)
 *   $canDelete   -> boolean (tampilkan tombol Hapus)
 */
use function App\Controllers\isAdmin;

$userRoleId = (string) (session('user')['role_id'] ?? '');
$role       = $userRoleId === '1' ? 'admin' : ($userRoleId === '4' ? 'validator' : 'sekolah');

$canAdd     = $canAdd ?? ($role === 'admin');
$canEdit    = $canEdit ?? ($role === 'admin');
$canDelete  = $canDelete ?? ($role === 'admin');

?>
<style>
    .cabor-table td { vertical-align: middle; }
    .cabor-action { gap: 4px; flex-wrap: nowrap; }
    .cabor-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }
    .cabor-action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .12); }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Data Cabor'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="<?= base_url($role === 'admin' ? 'admin/atlet/data' : ($role === 'validator' ? 'validator/atlet/data' : 'sekolah/atlet/data')); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Data Cabor'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <?php if ($canAdd): ?>
        <div>
            <a href="<?= esc($addUrl); ?>" class="btn btn-primary-600 radius-8"><i class="ri-add-box-line"></i> Tambah Cabor</a>
        </div>
    <?php endif; ?>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= esc($title ?? 'Data Cabor'); ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table id="tableData" class="display table table-bordered table-hover table-striped cabor-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:70%" class="text-start">Nama</th>
                            <?php if ($canEdit || $canDelete): ?>
                                <th style="width:25%" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($cabor ?? [] as $c): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><?= esc($c['nama']); ?></td>
                                <?php if ($canEdit || $canDelete): ?>
                                    <td class="text-center align-middle">
                                        <div class="cabor-action">
                                            <?php if ($canEdit): ?>
                                                <a href="<?= esc($editUrl . $c['id']); ?>" class="cabor-action-btn btn-edit bg-warning-focus text-warning-main rounded-circle">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($canDelete): ?>
                                                <a id="<?= esc($c['id']); ?>" class="cabor-action-btn btn-delete bg-danger-focus text-danger-main rounded-circle">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        let table = new DataTable('#tableData', {
            responsive: true,
        });

        <?php if ($canDelete): ?>
        // delete cabor
        $(document).on('click', '.btn-delete', function() {
            const caborId = $(this).attr('id');

            Swal.fire({
                title: 'Yakin Hapus Data Cabor Tersebut?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#93999f',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= esc($deleteUrl); ?>' + caborId;
                }
            });
        });
        <?php endif; ?>
    });
</script>
