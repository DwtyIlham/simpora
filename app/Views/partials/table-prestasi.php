<?php
/**
 * Partial: Tabel Prestasi Kompetisi Standar
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $kompetisi   -> Array data kompetisi
 *   $title       -> Judul halaman
 *   $prestasiUrl -> URL prefix untuk lihat prestasi (akan ditambahkan encode_id)
 *   $canAddPrestasi -> boolean (tampilkan tombol Tambah Prestasi)
 *   $addPrestasiUrl -> URL halaman tambah prestasi
 */

use function App\Controllers\encode_id;
use function App\Controllers\format_tgl;
use function App\Controllers\isAdmin;

$userRoleId = (string) (session('user')['role_id'] ?? '');
$role       = $userRoleId === '1' ? 'admin' : ($userRoleId === '4' ? 'validator' : 'sekolah');

$canAddPrestasi = $canAddPrestasi ?? ($role === 'admin');
$prestasiUrl    = $prestasiUrl ?? base_url($role . '/kompetisi/prestasi/');
$addPrestasiUrl = $addPrestasiUrl ?? base_url($role . '/kompetisi/prestasi-add/');

?>
<style>
    .prestasi-table td { vertical-align: middle; }
    .prestasi-action { gap: 4px; flex-wrap: nowrap; }
    .prestasi-action-btn {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }
    .prestasi-action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .12); }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Data Prestasi'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="<?= base_url($role === 'admin' ? 'admin/kompetisi/data' : ($role === 'validator' ? 'validator/kompetisi/prestasi' : 'sekolah/kompetisi/prestasi')); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Data Prestasi'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <?php if ($canAddPrestasi): ?>
        <div>
            <a href="<?= esc($addPrestasiUrl); ?>" class="btn btn-primary-600 radius-8"><i class="ri-add-box-line"></i> Tambah Prestasi</a>
        </div>
    <?php endif; ?>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= esc($title ?? 'Data Prestasi'); ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="display table table-bordered table-hover table-striped prestasi-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:15%" class="text-start">Nama</th>
                            <th style="width:35%" class="text-start">Deskripsi</th>
                            <th style="width:10%" class="text-center">Tgl Mulai</th>
                            <th style="width:10%" class="text-center">Tgl Selesai</th>
                            <th style="width:10%" class="text-center">Tingkat</th>
                            <th style="width:15%" class="text-center">Aksi</th>
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
                                <td class="text-center align-middle">
                                    <div class="prestasi-action">
                                        <a href="<?= esc($prestasiUrl . encode_id($k['id'])); ?>"
                                            class="prestasi-action-btn btn-view-prestasi bg-primary-100 text-primary rounded-circle"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data Prestasi">
                                            <iconify-icon icon="game-icons:achievement" width="24" height="24"></iconify-icon>
                                        </a>
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

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    $(function() {
        let table = new DataTable('#dataTable', {
            responsive: true,
        });
    });
</script>
