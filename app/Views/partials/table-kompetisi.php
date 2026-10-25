<?php
/**
 * Partial: Tabel Kompetisi Standar
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $kompetisi   -> Array data kompetisi
 *   $title       -> Judul halaman
 *   $canAdd      -> boolean (tampilkan tombol Tambah)
 *   $canEdit     -> boolean (tampilkan tombol Edit)
 *   $canDelete   -> boolean (tampilkan tombol Hapus)
 *   $canViewPeserta -> boolean (tampilkan tombol Lihat Peserta)
 *   $addUrl      -> URL halaman tambah kompetisi
 *   $editUrl     -> URL edit kompetisi (prefix, akan ditambahkan ID)
 *   $deleteUrl   -> URL hapus kompetisi (prefix, akan ditambahkan ID)
 *   $pesertaUrl  -> URL lihat peserta (prefix, akan ditambahkan ID)
 *   $role        -> 'admin' | 'validator' | 'sekolah'
 */

use function App\Controllers\format_tgl;
use function App\Controllers\isAdmin;

$userRoleId = (string) (session('user')['role_id'] ?? '');
$role       = $userRoleId === '1' ? 'admin' : ($userRoleId === '4' ? 'validator' : 'sekolah');

$canAdd     = $canAdd ?? ($role === 'admin');
$canEdit    = $canEdit ?? ($role === 'admin');
$canDelete  = $canDelete ?? ($role === 'admin');
$canViewPeserta = $canViewPeserta ?? true;

$addUrl     = $addUrl ?? base_url('admin/kompetisi/add');
$editUrl    = $editUrl ?? base_url('admin/kompetisi/edit/');
$deleteUrl  = $deleteUrl ?? base_url('admin/kompetisi/delete/');
$pesertaUrl = $pesertaUrl ?? base_url($role . '/kompetisi/peserta/');

?>
<style>
    .kompetisi-table td { vertical-align: middle; }
    .kompetisi-action { gap: 4px; flex-wrap: nowrap; }
    .kompetisi-action-btn {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }
    .kompetisi-action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .12); }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Data Kompetisi'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="<?= base_url($role === 'admin' ? 'admin/atlet/data' : ($role === 'validator' ? 'validator/atlet/data' : 'sekolah/atlet/data')); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Data Kompetisi'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <?php if ($canAdd): ?>
        <div>
            <a href="<?= esc($addUrl); ?>" class="btn btn-primary-600 radius-8"><i class="ri-add-box-line"></i> Tambah Kompetisi</a>
        </div>
    <?php endif; ?>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= esc($title ?? 'Data Kompetisi'); ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table id="tableData" class="display table table-bordered table-hover table-striped kompetisi-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:15%" class="text-start">Nama</th>
                            <th style="width:35%" class="text-start">Deskripsi</th>
                            <th style="width:10%" class="text-center">Tgl Mulai</th>
                            <th style="width:10%" class="text-center">Tgl Selesai</th>
                            <th style="width:10%" class="text-center">Tingkat</th>
                            <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                <th style="width:15%" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($kompetisi ?? [] as $k): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><?= esc($k['nama']); ?></td>
                                <td class="align-middle" style="text-align: left;"><?= esc($k['deskripsi']); ?></td>
                                <td class="text-center align-middle"><?= esc(format_tgl($k['tgl_start'])); ?></td>
                                <td class="text-center align-middle"><?= esc(format_tgl($k['tgl_end'])); ?></td>
                                <td class="text-center align-middle"><?= esc(strtoupper($k['tingkat'] ?? '')); ?></td>
                                <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                    <td class="text-center align-middle">
                                        <div class="kompetisi-action">
                                            <a href="<?= esc($pesertaUrl . $k['id']); ?>"
                                                class="kompetisi-action-btn btn-view-idcard bg-primary-100 text-info-main rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Peserta Kompetisi">
                                                <iconify-icon icon="lucide:scan-eye"></iconify-icon>
                                            </a>
                                            <?php if ($canEdit): ?>
                                                <a href="<?= esc($editUrl . $k['id']); ?>" class="kompetisi-action-btn btn-edit bg-warning-focus text-warning-main rounded-circle">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($canDelete): ?>
                                                <a id="<?= esc($k['id']); ?>" class="kompetisi-action-btn btn-delete bg-danger-focus text-danger-main rounded-circle">
                                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    $(function() {
        let table = new DataTable('#tableData', {
            responsive: true,
            columnDefs: [{
                    targets: 4,
                    name: 'filter-sekolah'
                },
                {
                    targets: 6,
                    name: 'filter-cabor'
                },
                {
                    targets: 2,
                    name: 'filter-status'
                }
            ]
        });

        // delete kompetisi
        $(document).on('click', '.btn-delete', function() {
            const kompetisiId = $(this).attr('id');

            Swal.fire({
                title: 'Yakin Hapus Data Kompetisi Tersebut?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#93999f',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= esc($deleteUrl); ?>' + kompetisiId;
                }
            });
        });
    });
</script>
