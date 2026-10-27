<?php

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
// Perbaikan: role_id 1 = admin, 4 = validator, selainnya = sekolah
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
$sekolah  = $sekolah ?? [];
$admin_setting = $admin_setting ?? [];
$is_editable      = $admin_setting[0]['status'] ?? 0;
$permit_add_atlet = $admin_setting[1]['status'] ?? 0;

$isIjazahRequired = !in_array($sekolah['bentuk_pendidikan'] ?? '', ['SD', 'MI']);

// Daftar dokumen yang divalidasi (urutan tetap seperti sebelumnya)
$daftarDokumen = [
    ['field' => 'akte_status',      'label' => 'Akte Kelahiran',   'short' => 'Akte'],
    ['field' => 'foto_status',      'label' => 'Foto Atlet',        'short' => 'Foto'],
    ['field' => 'ktp_kia_kk_status', 'label' => 'KTP / KIA / KK',   'short' => 'KTP'],
    ['field' => 'nisn_status',      'label' => 'Kartu NISN',        'short' => 'NISN'],
    ['field' => 'ijazah_status',    'label' => 'Ijazah',            'short' => 'Ijazah', 'wajib' => $isIjazahRequired],
    ['field' => 'suket_status',     'label' => 'Surat Keterangan',  'short' => 'Suket'],
];

$statusLabel = [
    'valid'   => 'Valid',
    'pending' => 'Pending',
    'invalid' => 'Perlu Perbaikan',
];

$statusClass = [
    'valid'   => 'bg-success text-light',
    'pending' => 'bg-secondary text-light',
    'invalid' => 'bg-danger text-light',
];

$rows  = [];
$stats = [
    'total'   => 0,
    'valid'   => 0,
    'pending' => 0,
    'invalid' => 0,
];

foreach ($atlet as $a) {
    $hasPending  = false;
    $hasInvalid  = false;
    $validCount  = 0;
    $totalDokumen = 0;
    $docStates   = [];

    foreach ($daftarDokumen as $dok) {
        // Lewati ijazah bila tidak wajib (SD / MI)
        if (array_key_exists('wajib', $dok) && !$dok['wajib']) {
            continue;
        }

        $totalDokumen++;
        $status = $a[$dok['field']] ?? null;

        if ($status === 'invalid') {
            $hasInvalid = true;
        } elseif ($status === 'pending') {
            $hasPending = true;
        } elseif ($status === 'valid') {
            $validCount++;
        } else {
            // Status kosong / tidak dikenal berarti belum pernah divalidasi.
            // Jangan dianggap valid (penyebab atlet tampil "Valid" padahal belum dicek).
            $hasPending = true;
        }

        $docStates[] = [
            'label'  => $dok['label'],
            'short'  => $dok['short'],
            'status' => $status,
        ];
    }

    if ($hasInvalid) {
        $validationStatus = 'invalid';
    } elseif ($hasPending) {
        $validationStatus = 'pending';
    } else {
        $validationStatus = 'valid';
    }

    $stats[$validationStatus]++;
    $stats['total']++;

    // Cek keberadaan foto (dua kemungkinan FCPATH agar aman)
    $fotoFile   = $a['file_foto'] ?? '';
    $fotoExists = $fotoFile !== '' && (
        is_file(FCPATH . 'public/uploads/atlet/file_foto/' . $fotoFile) ||
        is_file(FCPATH . 'uploads/atlet/file_foto/' . $fotoFile)
    );

    $rows[] = [
        'atlet'        => $a,
        'status'       => $validationStatus,
        'docs'         => $docStates,
        'validCount'   => $validCount,
        'totalDokumen' => $totalDokumen,
        'fotoExists'   => $fotoExists,
        'canEdit'      => (($is_editable == 1) && $validationStatus === 'invalid') || $validationStatus === 'pending',
    ];
}

$persenValid = $stats['total'] > 0 ? round(($stats['valid'] / $stats['total']) * 100) : 0;
?>

<style>
    .atlet-stat-card {
        position: relative;
        height: 100%;
        border: 0;
        border-radius: 14px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
        overflow: hidden;
    }

    .atlet-stat-card::before {
        content: "";
        position: absolute;
        inset-block: 0;
        inset-inline-start: 0;
        width: 4px;
        background: var(--stat-accent, #2563eb);
    }

    .atlet-stat-card .stat-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .atlet-stat-card .stat-value {
        font-size: 1.55rem;
        line-height: 1.1;
        font-weight: 700;
        color: var(--text-primary-light, #0f172a);
    }

    .atlet-stat-card .stat-label {
        font-size: .78rem;
        color: var(--text-secondary-light, #64748b);
        margin-bottom: 0;
    }

    .atlet-stat-card .stat-note {
        font-size: .7rem;
        color: var(--text-secondary-light, #64748b);
    }

    .atlet-filter-card .form-label {
        font-size: .78rem;
        font-weight: 600;
        margin-bottom: .35rem;
    }

    .atlet-filter-card .form-select,
    .atlet-filter-card .form-control {
        border-radius: 10px;
        min-height: 42px;
    }

    .atlet-filter-card .select2-container--bootstrap-5 .select2-selection {
        min-height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
    }

    #dataTable {
        vertical-align: middle;
    }

    #dataTable thead th {
        white-space: normal;
    }

    #dataTable .min-w-0 {
        min-width: 0;
        overflow: hidden;
    }

    #dataTable tbody tr {
        transition: background-color .15s ease;
    }

    #dataTable tbody tr:hover {
        background: #f8fafc;
    }

    .atlet-avatar {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #e2e8f0;
        background: #f1f5f9;
    }

    .atlet-name {
        font-weight: 600;
        color: var(--text-primary-light, #0f172a);
        line-height: 1.25;
        max-width: 240px;
    }

    .atlet-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        font-size: .7rem;
        color: var(--text-secondary-light, #64748b);
    }

    .atlet-meta span {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .nomor-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        max-width: 100%;
        padding: 1px 8px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: .7rem;
        font-weight: 600;
        margin: 1px 2px 1px 0;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .doc-list {
        display: inline-flex;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 100%;
        align-items: center;
    }

    .doc-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        background: #cbd5e1;
        cursor: help;
        transition: transform .15s ease;
    }

    .doc-dot:hover {
        transform: scale(1.25);
    }

    .doc-dot.valid {
        background: #16a34a;
    }

    .doc-dot.pending {
        background: #f59e0b;
    }

    .doc-dot.invalid {
        background: #dc2626;
    }

    .table-action {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }

    .table-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(15, 23, 42, .12);
    }

    .table-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        flex-wrap: nowrap;
    }

    .table-empty-note {
        font-size: .78rem;
        color: var(--text-secondary-light, #64748b);
    }
</style>

<div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-24">
    <div>
        <h5 class="fw-semibold mb-1">Data Atlet Pelajar</h5>
        <p class="text-secondary-light mb-0 text-sm">
            Daftar atlet yang sudah didaftarkan oleh <?= esc($sekolah['nama'] ?? 'sekolah Anda'); ?>.
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="<?= site_url($role . '/atlet/data'); ?>" class="btn btn-sm bg-primary-50 text-primary-600 radius-8">
            <i class="ri-refresh-line"></i> Muat Ulang
        </a>
        <a href="<?= $permit_add_atlet === '0' ? '#' : base_url($role . '/atlet/add'); ?>"
            <?= $permit_add_atlet === '0'
                ? 'onclick="alert(\'Masa Pendaftaran Telah Berakhir\'); return false;" class="btn btn-primary-600 disabled radius-8"'
                : 'class="btn btn-primary-600 radius-8"' ?>>
            <i class="ri-add-box-line"></i> Tambah Atlet
        </a>
    </div>
</div>

<!-- Ringkasan data -->
<div class="row gy-3 mb-24">
    <div class="col-6 col-xl-3">
        <div class="card atlet-stat-card" style="--stat-accent:#2563eb">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="stat-icon bg-primary-50 text-primary-600">
                    <iconify-icon icon="lucide:users-round"></iconify-icon>
                </span>
                <div>
                    <p class="stat-label">Total Atlet</p>
                    <div class="stat-value"><?= number_format($stats['total'], 0, ',', '.'); ?></div>
                    <span class="stat-note">Atlet terdaftar</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card atlet-stat-card" style="--stat-accent:#16a34a">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="stat-icon bg-success-focus text-success-main">
                    <iconify-icon icon="lucide:badge-check"></iconify-icon>
                </span>
                <div>
                    <p class="stat-label">Valid</p>
                    <div class="stat-value"><?= number_format($stats['valid'], 0, ',', '.'); ?></div>
                    <span class="stat-note"><?= $persenValid; ?>% data lengkap</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card atlet-stat-card" style="--stat-accent:#f59e0b">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="stat-icon bg-warning-focus text-warning-main">
                    <iconify-icon icon="lucide:clock-3"></iconify-icon>
                </span>
                <div>
                    <p class="stat-label">Pending</p>
                    <div class="stat-value"><?= number_format($stats['pending'], 0, ',', '.'); ?></div>
                    <span class="stat-note">Menunggu validasi</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card atlet-stat-card" style="--stat-accent:#dc2626">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="stat-icon bg-danger-focus text-danger-main">
                    <iconify-icon icon="lucide:triangle-alert"></iconify-icon>
                </span>
                <div>
                    <p class="stat-label">Perlu Perbaikan</p>
                    <div class="stat-value"><?= number_format($stats['invalid'], 0, ',', '.'); ?></div>
                    <span class="stat-note">Berkas tidak sesuai</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card atlet-filter-card mb-24">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h6 class="fw-semibold mb-0">Filter Data</h6>
            <span class="table-empty-note">Persempit daftar atlet berdasarkan cabang olahraga, sekolah, atau status validasi.</span>
        </div>
        <button type="button" class="btn btn-sm bg-neutral-100 bg-hover-neutral-200 text-neutral-600 radius-8" id="resetFilter">
            <i class="ri-filter-off-line"></i> Reset Filter
        </button>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-lg-3 col-md-6">
                <label class="form-label">Cabang Olahraga</label>
                <div class="icon-field">
                    <select class="form-select select2" name="filter_cabor" id="filter_cabor" data-placeholder="Semua cabang olahraga">
                        <option value=""></option>
                        <?php foreach ($cabor as $c): ?>
                            <option value="<?= $c['id']; ?>" data-nama="<?= esc($c['nama']); ?>"><?= esc($c['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="icon"><iconify-icon icon="fluent:sport-24-regular"></iconify-icon></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label">Sekolah</label>
                <div class="icon-field">
                    <select class="form-select select2" name="filter_sekolah" id="filter_sekolah" data-placeholder="Semua sekolah">
                        <option value=""></option>
                        <option value="<?= $sekolah['id']; ?>" data-nama="<?= esc($sekolah['nama']); ?>"><?= esc($sekolah['nama']); ?></option>
                    </select>
                    <span class="icon"><iconify-icon icon="icon-park-outline:school"></iconify-icon></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label">Status Validasi</label>
                <div class="icon-field">
                    <select class="form-select" name="filter_status" id="filter_status">
                        <option value="">- Semua status -</option>
                        <option value="valid" data-status="valid">Valid</option>
                        <option value="pending" data-status="pending">Pending</option>
                        <option value="invalid" data-status="invalid">Perlu Perbaikan</option>
                    </select>
                    <span class="icon"><iconify-icon icon="icon-park-outline:validation"></iconify-icon></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label">Cari Atlet</label>
                <div class="icon-field">
                    <input type="text" class="form-control" id="searchAtlet" placeholder="Nama, NIK, atau NISN..." autocomplete="off">
                    <span class="icon"><iconify-icon icon="ion:search-outline"></iconify-icon></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h5 class="card-title mb-0">Daftar Atlet</h5>
            <span class="table-empty-note">Klik ikon info untuk melihat detail dan hasil validasi berkas.</span>
        </div>
        <span class="badge bg-primary-50 text-primary-600 radius-8 px-12 py-6">
            <?= number_format($stats['total'], 0, ',', '.'); ?> atlet
        </span>
    </div>
    <div class="card-body table-responsive atlet-table-shell">
        <table class="table bordered-table table-atlet table-atlet-sekolah mb-0 align-middle" id="dataTable" data-page-length="10">
            <thead>
                <tr>
                    <th class="text-center col-no" scope="col">No.</th>
                    <th class="text-center col-aksi" scope="col">Aksi</th>
                    <th class="text-center col-validasi" scope="col">Validasi</th>
                    <th class="col-nama" scope="col">Atlet</th>
                    <th class="col-sekolah" scope="col">Sekolah</th>
                    <th class="text-center col-jk" scope="col">JK</th>
                    <th class="col-cabor" scope="col">Cabang Olahraga</th>
                    <th class="col-nomor" scope="col">Nomor Lomba</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <?php
                    $a              = $row['atlet'];
                    $status         = $row['status'];
                    $nomorList      = array_filter(array_map('trim', explode(',', (string) ($a['nomor_cabor'] ?? ''))));
                    $jk             = $a['jenis_kelamin'] ?? '';
                    $jkLabel        = $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '-');
                    $jkShort        = $jk === 'L' ? 'L' : ($jk === 'P' ? 'P' : '-');
                    $jkBadgeClass    = $jk === 'L' ? 'bg-primary-50 text-primary-600' : ($jk === 'P' ? 'bg-danger-focus text-danger-main' : 'bg-neutral-100 text-neutral-600');
                    ?>
                    <tr>
                        <td class="text-center text-secondary-light"><?= $no; ?></td>

                        <td class="text-center">
                            <div class="table-action-group">
                                <?php if ($status === 'valid'): ?>
                                    <a href="javascript:void(0)" data-id="<?= $a['id']; ?>"
                                        class="table-action btn-view-idcard bg-info-focus text-info-main"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat ID Card" aria-label="Lihat ID Card">
                                        <iconify-icon icon="lucide:id-card-lanyard"></iconify-icon>
                                    </a>
                                <?php endif; ?>

                                <a href="javascript:void(0)" data-id="<?= $a['id']; ?>"
                                    class="table-action view-atlet bg-primary-light text-primary-600"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Detail &amp; hasil validasi" aria-label="Detail atlet">
                                    <iconify-icon icon="lucide:info"></iconify-icon>
                                </a>

                                <?php if ($row['canEdit']): ?>
                                    <a href="<?= site_url('sekolah/atlet/edit/') . $a['id']; ?>"
                                        class="table-action bg-warning-focus text-warning-main"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah data atlet" aria-label="Ubah data atlet">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                <?php endif; ?>

                                <?php if ($status === 'valid' && !$row['fotoExists']): ?>
                                    <a href="<?= site_url('sekolah/atlet/edit-berkas/') . $a['id']; ?>"
                                        class="table-action bg-success-focus text-success-main"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Unggah / lengkapi berkas" aria-label="Unggah berkas">
                                        <iconify-icon icon="lucide:cloud-upload"></iconify-icon>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="text-center" data-search="<?= $status; ?>">
                            <span class="badge <?= $statusClass[$status]; ?> radius-8"><?= $statusLabel[$status]; ?></span>
                            <div class="text-secondary-light mt-1" style="font-size:.68rem;">
                                <?= $row['validCount']; ?>/<?= $row['totalDokumen']; ?> valid
                            </div>
                            <div class="doc-list mt-1" aria-label="Status dokumen">
                                <?php foreach ($row['docs'] as $doc): ?>
                                    <?php
                                    $docState = in_array($doc['status'], ['valid', 'pending', 'invalid'], true) ? $doc['status'] : 'pending';
                                    $docText  = $docState === 'valid' ? 'Valid' : ($docState === 'invalid' ? 'Tidak sesuai' : 'Belum dicek');
                                    ?>
                                    <span class="doc-dot <?= $docState; ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="<?= esc($doc['label']); ?>: <?= $docText; ?>"></span>
                                <?php endforeach; ?>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3 atlet-name-cell">
                                <img src="<?= $row['fotoExists'] ? base_url('public/uploads/atlet/file_foto/' . $a['file_foto']) : base_url('public/assets/images/user.png'); ?>"
                                    alt="Foto <?= esc($a['nama'] ?? ''); ?>"
                                    class="atlet-avatar"
                                    onerror="this.onerror=null;this.src='<?= base_url('public/assets/images/user.png'); ?>';">
                                <div class="min-w-0">
                                    <div class="atlet-name text-truncate" title="<?= esc($a['nama'] ?? '-'); ?>">
                                        <?= esc($a['nama'] ?? '-'); ?>
                                    </div>
                                    <div class="atlet-meta">
                                        <span title="NIK"><i class="ri-id-card-line"></i> <?= esc($a['nik'] ?? '-'); ?></span>
                                        <span title="NISN"><i class="ri-hashtag"></i> <?= esc($a['nisn'] ?? '-'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td data-search="<?= esc($a['sekolah'] ?? '', 'attr'); ?>">
                            <div class="fw-medium"><?= esc($a['sekolah'] ?? '-'); ?></div>
                            <?php if (!empty($sekolah['bentuk_pendidikan'])): ?>
                                <span class="text-secondary-light" style="font-size:.7rem;"><?= esc($sekolah['bentuk_pendidikan']); ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <span class="badge <?= $jkBadgeClass; ?> radius-8" title="<?= $jkLabel; ?>"><?= $jkShort; ?></span>
                        </td>

                        <td data-search="<?= esc($a['cabor'] ?? '', 'attr'); ?>">
                            <?php if (!empty($a['cabor'])): ?>
                                <span class="badge bg-primary-50 text-primary-600 radius-8"><?= esc($a['cabor']); ?></span>
                            <?php else: ?>
                                <span class="text-secondary-light">-</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($nomorList): ?>
                                <?php foreach ($nomorList as $nomor): ?>
                                    <span class="nomor-chip"><i class="ri-flag-2-line"></i> <?= esc($nomor); ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-secondary-light">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('partials/atlet-detail-modal', [
    'canValidate' => false,
    'role'        => 'sekolah',
]); ?>

<!-- Modal QR -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">ID CARD PESERTA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-1">
                <div class="card mt-12 bg-light">
                    <h5 class="card-title mb-0" id="card-title"></h5>
                    <div class="card-body m-auto p-1">
                        <div class="idcard" style="text-align: center;">
                            <!-- Header -->
                            <div class="header d-flex align-items-center justify-between text-center">
                                <img src="<?= base_url('public/assets/images/logo_bna.svg') ?>" class="logo img-fluid" />
                                <div class="event fw-bold align-middle" id="idcard-title"></div>
                                <img src="<?= base_url('public/assets/images/icon.png') ?>" id="logo-simpora" class="logo img-fluid" />
                            </div>
                            <!-- Foto -->
                            <div class="foto-wrap text-center mt-1">
                                <!-- Foto Atlet -->
                                <img src="" id="idcard-foto" class="foto shadow-sm" style="max-height:125px; width: auto !important;" />
                            </div>

                            <div class="role mt-1">ATLET</div>

                            <!-- Nama -->
                            <div class="nama fw-bold text-center mt-0" id="idcard-atlet">
                                <!-- Nama Atlet -->
                            </div>

                            <!-- Sekolah -->
                            <div class="sekolah text-center small text-muted" id="idcard-sekolah">
                                <!-- Nama Sekolah -->
                            </div>

                            <!-- Cabor -->
                            <div class="cabor text-center small mb-0">
                                <span class="fw-semibold" id="idcard-cabor">
                                    <!-- Nama Cabor -->
                                </span>
                            </div>

                            <div class="cabor text-center small mb-0">
                                <span class="fw-semibold" id="idcard-nomor-lomba">
                                    <!-- Nomor Lomba -->
                                </span>
                            </div>

                            <!-- QR Code -->
                            <div class="qrcode-wrap mb-2" style="position: relative; display: inline-block;">
                                <img src="<?= base_url('public/assets/images/dummy-qr.webp') ?>" id="idcard-qrcode" class="qrcode img-fluid p-4" />
                                <div id="idcard-qr-loader" class="qr-loader d-none">
                                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                                </div>
                            </div>

                            <!-- Footer Bar -->
                            <div class="footer"><span class="text-light"><small>SILAGAPORA - BANJARNEGARA</small></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="downloadIdCard()">Download</button>
            </div>
        </div>
    </div>
</div>

<style>
    .idcard {
        width: 8.5cm;
        height: 13.5cm;
        transform: none !important;
        zoom: 1 !important;
        background: #ffffff;
        border-radius: 14px;
        padding: 10px 12px;
        position: relative;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        box-sizing: border-box;
    }

    .idcard img.logo,
    .idcard img.qrcode,
    .idcard img.foto {
        max-width: 100%;
        height: auto;
    }

    @media print {
        .idcard {
            width: 8.5cm;
            height: 13.5cm;
        }
    }

    .idcard img {
        image-rendering: crisp-edges;
    }

    .header {
        background: linear-gradient(135deg, #003d86, #005fcb);
        color: #fff;
        padding: 10px 6px 14px;
        border-radius: 10px;
    }

    .logo {
        width: 30px;
        left: 10px;
        top: 8px;
        margin: 5px;
    }

    #logo-simpora {
        filter: brightness(0) invert(1);
    }

    .event {
        font-size: 16px;
        line-height: 1.2;
    }

    .role {
        font-size: 12px;
        margin-top: -2px;
        letter-spacing: 0.3px;
    }

    .foto-wrap .foto {
        width: 3cm;
        height: 4cm;
        object-fit: cover;
        border-radius: 8px;
    }

    .nama {
        font-size: 17px;
        color: #002752;
    }

    .sekolah {
        font-size: 13px;
    }

    .cabor {
        font-size: 12px;
    }

    .qrcode {
        padding: 4px;
        width: 93px;
        height: 93px;
        bottom: 22px;
    }

    .qrcode-wrap {
        position: relative;
        display: inline-block;
    }

    .qr-loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 103px;
        height: 103px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.75);
        border-radius: 8px;
        z-index: 10;
    }

    .footer {
        width: 100%;
        height: auto;
        background: #003d86;
        position: absolute;
        bottom: 0;
        left: 0;
        border-radius: 0 0 12px 12px;
    }
</style>

<script>
(function waitForJQuery() {
    if (!window.jQuery) {
        window.setTimeout(waitForJQuery, 25);
        return;
    }

    window.jQuery(function($) {
    const dataAtletTable = new window.DataTable('#dataTable', {
        pageLength: 10,
        autoWidth: false,
        order: [],
        columnDefs: [{
            targets: [0, 1, 2, 7],
            orderable: false
        }],
        layout: {
            topStart: null,
            topEnd: null,
            bottomStart: 'info',
            bottomEnd: 'paging'
        },
        language: {
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ atlet',
            infoEmpty: 'Tidak ada atlet',
            infoFiltered: '(difilter dari _MAX_ atlet)',
            zeroRecords: 'Tidak ada atlet yang cocok dengan filter.',
            emptyTable: 'Belum ada atlet yang didaftarkan.',
            paginate: {
                previous: '<i class="ri-arrow-left-s-line"></i>',
                next: '<i class="ri-arrow-right-s-line"></i>'
            }
        }
    });

    function escapeRegex(value) {
        return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function applyAtletFilters() {
        const cabor = $('#filter_cabor option:selected').data('nama') || '';
        const sekolah = $('#filter_sekolah option:selected').data('nama') || '';
        const status = $('#filter_status option:selected').data('status') || '';

        dataAtletTable.columns().search('');

        // Index kolom: 2 = Validasi, 4 = Sekolah, 6 = Cabang Olahraga
        if (cabor) {
            dataAtletTable.column(6).search('^' + escapeRegex(cabor) + '$', true, false);
        }

        if (sekolah) {
            dataAtletTable.column(4).search('^' + escapeRegex(sekolah) + '$', true, false);
        }

        if (status) {
            dataAtletTable.column(2).search('^' + escapeRegex(status) + '$', true, false);
        }

        dataAtletTable.draw();
    }

    $('#filter_cabor, #filter_sekolah, #filter_status').on('change', applyAtletFilters);

    let searchTimer;
    $('#searchAtlet').on('input', function() {
        const value = this.value;
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => dataAtletTable.search(value).draw(), 250);
    });

    $('#resetFilter').on('click', function() {
        $('#filter_cabor').val(null).trigger('change.select2');
        $('#filter_sekolah').val(null).trigger('change.select2');
        $('#filter_status').val('');
        $('#searchAtlet').val('');

        dataAtletTable.search('');
        dataAtletTable.columns().search('');
        dataAtletTable.draw();
    });

    // Re-init tooltip setiap tabel digambar ulang
    dataAtletTable.on('draw.dt', function() {
        document.querySelectorAll('#dataTable [data-bs-toggle="tooltip"]').forEach(function(el) {
            const existing = bootstrap.Tooltip.getInstance(el);
            if (existing) existing.dispose();
            new bootstrap.Tooltip(el);
        });
    });

    // view detail atlet (readonly untuk sekolah)
    $(document).on('click', '.view-atlet', function() {

        const atletId = $(this).data('id');

        function detectImageSize() {
            // Cari semua link view-img yang belum punya ukuran
            document.querySelectorAll('.view-img:not([data-pswp-width])').forEach(a => {

                const img = new window.Image();
                img.src = a.href;

                img.onload = function() {
                    a.setAttribute('data-pswp-width', this.width);
                    a.setAttribute('data-pswp-height', this.height);
                };
            });
        }

        $.ajax({
            url: "<?= site_url('api/get_detail_atlet'); ?>",
            method: "GET",
            data: {
                id: atletId
            },
            success: function(res) {
                if (!res || res.status === 'error' || !res.data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal memuat detail atlet',
                        text: (res && res.message) ? res.message : 'Data atlet tidak ditemukan.'
                    });
                    return;
                }

                // Bisa saja atlet belum punya baris atlet_validasi (LEFT JOIN = null).
                const validasi = res.validasi || {};
                const statusValidasi = function(key) {
                    return validasi[key] || 'pending';
                };

                const bentuk = res.data.bentuk_pendidikan || '';

                $('#viewAtletModal')
                    .data('atlet-id', atletId)
                    .data('bentuk', bentuk);

                $("#v-nama").text(res.data.nama || '-');
                $("#v-header-nama").text(res.data.nama || '-');
                $("#v-nisn").text(res.data.nisn || '-');
                $("#v-header-nisn").text(res.data.nisn || '-');
                $("#v-header-sekolah").text(res.data.sekolah || '-');
                $("#v-nik").text(res.data.nik || '-');
                $("#v-sekolah").text(res.data.sekolah || '-');
                $("#v-cabor").text(res.data.cabor || '-');
                $("#v-nomor-lomba").text([
                    res.data.nomor_cabor,
                    res.data.jenis,
                    res.data.detail,
                    res.data.kategori
                ].filter(Boolean).join(' ') || '-');
                $("#v-jenjang").text(res.data.jenjang || '-');
                $("#v-jk").text(res.data.jenis_kelamin || '-');
                $("#v-ttl").text([res.data.tempat_lahir, res.data.tanggal_lahir].filter(Boolean).join(', ') || '-');
                $("#v-alamat").text(res.data.alamat || '-');

                $('#viewAtletModal').modal('show');
                $("#file-gallery").html("<p class='text-muted p-4'>Memuat berkas...</p>");

                const fileMap = {
                    akte_status: 'file_akte',
                    foto_status: 'file_foto',
                    ktp_kia_kk_status: 'file_ktp_kia_kk',
                    nisn_status: 'file_nisn',
                    ijazah_status: 'file_ijazah',
                    suket_status: 'file_suket'
                };

                const folderMap = {
                    akte_status: `<?= base_url('public/uploads/atlet/file_akte/'); ?>`,
                    foto_status: `<?= base_url('public/uploads/atlet/file_foto/'); ?>`,
                    ktp_kia_kk_status: `<?= base_url('public/uploads/atlet/file_ktp_kia_kk/'); ?>`,
                    nisn_status: `<?= base_url('public/uploads/atlet/file_nisn/'); ?>`,
                    ijazah_status: `<?= base_url('public/uploads/atlet/file_ijazah/'); ?>`,
                    suket_status: `<?= base_url('public/uploads/atlet/file_suket/'); ?>`
                };

                let html = "";
                // Dokumen wajib untuk sekolah sama seperti aturan validasi (ijazah diabaikan SD/MI)
                const required = window.getRequiredDocs ? window.getRequiredDocs(bentuk) : [{
                    key: 'akte_status', label: 'Akte Kelahiran', type: 'akte'
                }, {
                    key: 'foto_status', label: 'Foto Atlet', type: 'foto'
                }, {
                    key: 'ktp_kia_kk_status', label: 'KTP / KIA / KK', type: 'ktp_kia_kk'
                }, {
                    key: 'nisn_status', label: 'Kartu NISN', type: 'nisn'
                }, {
                    key: 'suket_status', label: 'Surat Keterangan', type: 'suket'
                }, {
                    key: 'ijazah_status', label: 'Ijazah', type: 'ijazah'
                }].filter(d => ['SD', 'MI'].includes(bentuk || '') || d.key !== 'ijazah_status');

                required.forEach(function(doc) {
                    const file = res.data[fileMap[doc.key]];
                    const status = statusValidasi(doc.key);

                    if (file) {
                        html += templateFile(doc.label, folderMap[doc.key] + file, status, doc.type, atletId, 'sekolah');
                    } else {
                        html += templateMissing(doc.label, doc.type, status);
                    }
                });

                $("#file-gallery").html(html);
                detectImageSize();
                reInitGallery();
            }
        });
    });
    });
})();
</script>

<?= $this->endSection(); ?>
