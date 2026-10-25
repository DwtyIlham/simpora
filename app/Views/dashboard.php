<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<?php
$user       = session()->get('user') ?? [];
$roleId     = (string) ($user['role_id'] ?? '');
$role       = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
$roleLabel  = $role === 'admin' ? 'Administrator' : ($role === 'validator' ? 'Validator' : 'Operator Sekolah');
$nama       = $user['nama'] ?? 'Pengguna';
$d          = $data ?? [];

$totalAtlet    = (int) ($d['total_atlet'] ?? 0);
$totalValid    = (int) ($d['total_valid'] ?? 0);
$totalPending  = (int) ($d['total_pending'] ?? 0);
$totalInvalid  = (int) ($d['total_invalid'] ?? 0);
$totalCabor    = (int) ($d['total_cabor'] ?? 0);
$totalKompetisi = (int) ($d['total_kompetisi'] ?? 0);
$totalSekolah  = (int) ($d['total_sekolah'] ?? 0);
$pctValid      = $totalAtlet > 0 ? (int) round($totalValid / $totalAtlet * 100) : 0;

$caborChart   = $d['cabor_chart'] ?? [];
$medali       = $d['medali'] ?? ['emas' => 0, 'perak' => 0, 'perunggu' => 0, 'total' => 0];
$medaliCabor  = $d['medali_cabor'] ?? [];
$kompetisi    = $d['kompetisi_terbaru'] ?? [];
$atletTerbaru = $d['atlet_terbaru'] ?? [];
$perluTindakan = $d['perlu_tindakan'] ?? [];

$hour     = (int) date('H');
$greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));

$linkAtlet    = $role === 'admin' ? 'admin/atlet/data' : ($role === 'validator' ? 'validator/atlet/data' : 'sekolah/atlet/data');
$linkPrestasi = $role === 'admin' ? 'admin/kompetisi/prestasi' : ($role === 'validator' ? 'validator/kompetisi/prestasi' : 'sekolah/kompetisi/prestasi');
$linkKompetisi = $role === 'admin' ? 'admin/kompetisi/data' : ($role === 'validator' ? 'validator/kompetisi/prestasi' : 'sekolah/kompetisi/data');
$linkTambah = $role === 'sekolah' ? 'sekolah/atlet/add' : $linkAtlet;

$fmt = static fn($n) => number_format((int) $n, 0, ',', '.');

$fmtTanggal = static function ($date) {
    if (!$date) {
        return '-';
    }
    $ts = strtotime($date);
    if (!$ts) {
        return '-';
    }
    $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return date('d', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
};

$statusBadge = static function (?string $status) {
    $map = [
        'valid'   => ['Valid', 'dash-badge-success'],
        'invalid' => ['Perlu Perbaikan', 'dash-badge-danger'],
        'pending' => ['Menunggu', 'dash-badge-warning'],
    ];
    [$label, $class] = $map[$status] ?? ['Belum Dicek', 'dash-badge-muted'];
    return '<span class="dash-badge ' . $class . '">' . $label . '</span>';
};

$tones = [
    'primary' => ['#eff6ff', '#2563eb'],
    'warning' => ['#fff7ed', '#ea580c'],
    'success' => ['#ecfdf5', '#059669'],
    'danger'  => ['#fef2f2', '#dc2626'],
    'info'    => ['#ecfeff', '#0891b2'],
];

$cards = [];
if ($role === 'admin') {
    $cards = [
        ['label' => 'Total Atlet', 'value' => $totalAtlet, 'sub' => $totalSekolah . ' sekolah terdaftar', 'icon' => 'solar:users-group-rounded-bold', 'tone' => 'primary', 'href' => $linkAtlet],
        ['label' => 'Menunggu Validasi', 'value' => $totalPending, 'sub' => 'atlet perlu ditinjau', 'icon' => 'solar:clock-circle-bold', 'tone' => 'warning', 'href' => $linkAtlet],
        ['label' => 'Atlet Valid', 'value' => $totalValid, 'sub' => $pctValid . '% dari total atlet', 'icon' => 'solar:check-circle-bold', 'tone' => 'success', 'href' => $linkAtlet],
        ['label' => 'Kompetisi', 'value' => $totalKompetisi, 'sub' => $totalCabor . ' cabang olahraga', 'icon' => 'solar:cup-star-bold', 'tone' => 'info', 'href' => $linkKompetisi],
    ];
} elseif ($role === 'validator') {
    $cards = [
        ['label' => 'Atlet Cabor Saya', 'value' => $totalAtlet, 'sub' => $totalCabor . ' cabor ditugaskan', 'icon' => 'solar:users-group-rounded-bold', 'tone' => 'primary', 'href' => $linkAtlet],
        ['label' => 'Menunggu Validasi', 'value' => $totalPending, 'sub' => 'atlet perlu ditinjau', 'icon' => 'solar:clock-circle-bold', 'tone' => 'warning', 'href' => $linkAtlet],
        ['label' => 'Sudah Valid', 'value' => $totalValid, 'sub' => $pctValid . '% dari total atlet', 'icon' => 'solar:check-circle-bold', 'tone' => 'success', 'href' => $linkAtlet],
        ['label' => 'Perlu Perbaikan', 'value' => $totalInvalid, 'sub' => 'atlet dikembalikan', 'icon' => 'solar:refresh-circle-bold', 'tone' => 'danger', 'href' => $linkAtlet],
    ];
} else {
    $cards = [
        ['label' => 'Atlet Saya', 'value' => $totalAtlet, 'sub' => $totalCabor . ' cabor diikuti', 'icon' => 'solar:users-group-rounded-bold', 'tone' => 'primary', 'href' => $linkAtlet],
        ['label' => 'Menunggu Validasi', 'value' => $totalPending, 'sub' => 'atlet dalam proses', 'icon' => 'solar:clock-circle-bold', 'tone' => 'warning', 'href' => $linkAtlet],
        ['label' => 'Atlet Valid', 'value' => $totalValid, 'sub' => $pctValid . '% terverifikasi', 'icon' => 'solar:check-circle-bold', 'tone' => 'success', 'href' => $linkAtlet],
        ['label' => 'Perlu Perbaikan', 'value' => $totalInvalid, 'sub' => 'atlet perlu unggah ulang', 'icon' => 'solar:refresh-circle-bold', 'tone' => 'danger', 'href' => $linkAtlet],
    ];
}

$caborLabels = array_map(static fn($r) => $r['nama'] ?? 'Tanpa Cabor', $caborChart);
$caborValues = array_map(static fn($r) => (int) ($r['total'] ?? 0), $caborChart);

$jsonFlags = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
?>

<style>
    .dash-hero {
        background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 55%, #ecfeff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
    }

    .dash-role-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 600;
    }

    .dash-stat-card {
        display: block;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .dash-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, .08);
    }

    .dash-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex: 0 0 auto;
    }

    .dash-stat-value {
        font-size: 30px;
        line-height: 1.1;
        font-weight: 700;
        color: #0f172a;
        margin: 16px 0 4px;
    }

    .dash-muted {
        color: #64748b;
    }

    .dash-label {
        color: #334155;
        font-size: 14px;
        font-weight: 600;
    }

    .dash-strong {
        color: #0f172a;
    }

    .dash-strong-sm {
        color: #0f172a;
        font-size: 13px;
        font-weight: 600;
    }

    .dash-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .dash-badge-success { background: #ecfdf5; color: #047857; }
    .dash-badge-danger  { background: #fef2f2; color: #b91c1c; }
    .dash-badge-warning { background: #fff7ed; color: #c2410c; }
    .dash-badge-muted   { background: #f1f5f9; color: #64748b; }

    .dash-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .dash-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #eef2f7;
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        transition: background .2s ease, border-color .2s ease;
    }

    .dash-list-item:hover {
        background: #f8fafc;
        border-color: #dbeafe;
    }

    .dash-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #eff6ff;
        color: #1d4ed8;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .dash-table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #64748b;
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0;
        padding: 10px 12px;
        white-space: nowrap;
    }

    .dash-table tbody td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .dash-table tbody tr:last-child td {
        border-bottom: none;
    }

    .dash-empty {
        padding: 28px 16px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
    }

    .dash-progress {
        height: 8px;
        border-radius: 999px;
        background: #f1f5f9;
        overflow: hidden;
        display: flex;
    }

    .dash-progress span {
        display: block;
        height: 100%;
    }

    .dash-medal {
        border-radius: 12px;
        padding: 14px 10px;
        text-align: center;
        border: 1px solid #eef2f7;
    }

    .dash-medal strong {
        display: block;
        font-size: 24px;
        line-height: 1.2;
        color: #0f172a;
    }

    .dash-medal small {
        font-size: 11px;
        color: #64748b;
    }

    .dash-cabor-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    [data-theme="dark"] .dash-hero {
        background: linear-gradient(135deg, #0f172a 0%, #111827 55%, #0b2530 100%);
        border-color: #1e293b;
    }

    [data-theme="dark"] .dash-role-chip {
        background: #111827;
        border-color: #1e3a5f;
        color: #93c5fd;
    }

    [data-theme="dark"] .dash-stat-value,
    [data-theme="dark"] .dash-hero h4 {
        color: #f8fafc;
    }

    [data-theme="dark"] .dash-muted {
        color: #94a3b8;
    }

    [data-theme="dark"] .dash-label,
    [data-theme="dark"] .dash-strong,
    [data-theme="dark"] .dash-strong-sm {
        color: #e2e8f0;
    }

    [data-theme="dark"] .dash-list-item {
        border-color: #1e293b;
    }

    [data-theme="dark"] .dash-list-item:hover {
        background: #111827;
        border-color: #1e3a5f;
    }

    [data-theme="dark"] .dash-avatar {
        background: #172554;
        color: #93c5fd;
    }

    [data-theme="dark"] .dash-table thead th {
        color: #94a3b8;
        border-bottom-color: #1e293b;
    }

    [data-theme="dark"] .dash-table tbody td {
        border-bottom-color: #1e293b;
    }

    [data-theme="dark"] .dash-progress {
        background: #1e293b;
    }

    [data-theme="dark"] .dash-medal {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    [data-theme="dark"] .dash-medal strong {
        color: #f8fafc;
    }

    [data-theme="dark"] .dash-medal small {
        color: #94a3b8;
    }

    @media (max-width: 575.98px) {
        .dash-hero { padding: 18px; }
        .dash-stat-value { font-size: 24px; }
    }
</style>

<div class="dash-hero d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <span class="dash-role-chip mb-2">
            <iconify-icon icon="solar:shield-user-bold"></iconify-icon>
            <?= esc($roleLabel); ?>
        </span>
        <h4 class="fw-semibold mb-1"><?= $greeting; ?>, <?= esc($nama); ?></h4>
        <p class="dash-muted mb-0">
            <?php if ($role === 'admin') : ?>
                Ringkasan data SILAGAPORA secara keseluruhan.
            <?php elseif ($role === 'validator') : ?>
                Ringkasan atlet pada cabang olahraga yang Anda validasi.
            <?php else : ?>
                Ringkasan data atlet dan berkas sekolah Anda.
            <?php endif; ?>
        </p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= base_url($linkAtlet); ?>" class="btn btn-primary-600 btn-sm">
            <iconify-icon icon="solar:users-group-rounded-bold" class="me-1"></iconify-icon>
            <?= $role === 'validator' ? 'Verifikasi Atlet' : 'Data Atlet'; ?>
        </a>
        <?php if ($role === 'sekolah') : ?>
            <a href="<?= base_url($linkTambah); ?>" class="btn btn-outline-primary-600 btn-sm">
                <iconify-icon icon="solar:add-circle-bold" class="me-1"></iconify-icon>
                Tambah Atlet
            </a>
        <?php endif; ?>
        <a href="<?= base_url($linkPrestasi); ?>" class="btn btn-outline-primary-600 btn-sm">
            <iconify-icon icon="solar:medal-ribbons-star-bold" class="me-1"></iconify-icon>
            Prestasi
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('welcome')) : ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;">
        <div id="toastWelcome" class="toast shadow-lg border-0 rounded-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header bg-primary-500 text-white rounded-top-3">
                <i class="bi bi-person-check me-2"></i>
                <strong class="me-auto">Login Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"><?= esc(session()->getFlashdata('welcome')); ?></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('toastWelcome');
            if (el && window.bootstrap) {
                new bootstrap.Toast(el).show();
            }
        });
    </script>
<?php endif; ?>

<?php if (($role === 'sekolah' && $totalInvalid > 0) || ($role !== 'sekolah' && $totalPending > 0)) : ?>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-24 px-20 py-16 radius-12"
        style="background:#fff7ed;border:1px solid #fed7aa;">
        <div class="d-flex align-items-center gap-2">
            <iconify-icon icon="solar:danger-triangle-bold" style="color:#ea580c;font-size:22px;"></iconify-icon>
            <div>
                <strong class="d-block" style="color:#9a3412;">
                    <?= $role === 'sekolah'
                        ? $totalInvalid . ' atlet perlu perbaikan berkas'
                        : $totalPending . ' atlet menunggu validasi'; ?>
                </strong>
                <small style="color:#c2410c;">
                    <?= $role === 'sekolah'
                        ? 'Periksa catatan validator, lalu unggah ulang dokumen yang diminta.'
                        : 'Tinjau kelengkapan dokumen agar atlet dapat segera diverifikasi.'; ?>
                </small>
            </div>
        </div>
        <a href="<?= base_url($linkAtlet); ?>" class="btn btn-sm btn-primary-600">
            <?= $role === 'sekolah' ? 'Perbaiki Berkas' : 'Mulai Validasi'; ?>
        </a>
    </div>
<?php endif; ?>

<div class="row gy-4 mb-24">
    <?php foreach ($cards as $card) : ?>
        <?php [$bg, $fg] = $tones[$card['tone']]; ?>
        <div class="col-6 col-xl-3">
            <a href="<?= base_url($card['href']); ?>" class="dash-stat-card card radius-8 border-0 h-100 text-decoration-none">
                <div class="card-body p-20">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <span class="dash-stat-icon" style="background:<?= $bg; ?>;color:<?= $fg; ?>;">
                            <iconify-icon icon="<?= esc($card['icon']); ?>"></iconify-icon>
                        </span>
                        <iconify-icon icon="solar:arrow-right-up-linear" style="color:#cbd5e1;font-size:18px;"></iconify-icon>
                    </div>
                    <div class="dash-stat-value"><?= $fmt($card['value']); ?></div>
                    <div class="dash-label"><?= esc($card['label']); ?></div>
                    <div class="dash-muted" style="font-size:12px;"><?= esc($card['sub']); ?></div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="row gy-4 mb-24">
    <div class="col-xl-8">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h6 class="fw-semibold mb-1">Distribusi Atlet per Cabor</h6>
                        <p class="dash-muted mb-0" style="font-size:12px;">6 cabang olahraga dengan atlet terbanyak</p>
                    </div>
                    <span class="dash-badge dash-badge-muted"><?= $fmt($totalAtlet); ?> atlet</span>
                </div>
                <?php if (empty($caborChart)) : ?>
                    <div class="dash-empty">
                        <iconify-icon icon="solar:chart-2-outline" style="font-size:32px;color:#cbd5e1;"></iconify-icon>
                        <div>Belum ada data atlet untuk ditampilkan.</div>
                    </div>
                <?php else : ?>
                    <div id="chartCabor" style="min-height:300px;"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <h6 class="fw-semibold mb-0">Progres Validasi</h6>
                    <a href="<?= base_url($linkAtlet); ?>" class="dash-muted" style="font-size:12px;text-decoration:none;">Lihat</a>
                </div>
                <?php if ($totalAtlet > 0) : ?>
                    <div id="chartValidasi" style="min-height:190px;"></div>
                <?php else : ?>
                    <div class="dash-empty">
                        <iconify-icon icon="solar:chart-2-outline" style="font-size:32px;color:#cbd5e1;"></iconify-icon>
                        <div>Belum ada data atlet.</div>
                    </div>
                <?php endif; ?>
                <div class="dash-progress mb-3" aria-hidden="true">
                    <?php if ($totalAtlet > 0) : ?>
                        <span style="width:<?= round($totalValid / $totalAtlet * 100, 2); ?>%;background:#10b981;"></span>
                        <span style="width:<?= round($totalPending / $totalAtlet * 100, 2); ?>%;background:#f59e0b;"></span>
                        <span style="width:<?= round($totalInvalid / $totalAtlet * 100, 2); ?>%;background:#ef4444;"></span>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column gap-2" style="font-size:13px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <span><span class="dash-cabor-dot" style="background:#10b981;"></span>Valid</span>
                        <strong><?= $fmt($totalValid); ?></strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span><span class="dash-cabor-dot" style="background:#f59e0b;"></span>Menunggu</span>
                        <strong><?= $fmt($totalPending); ?></strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span><span class="dash-cabor-dot" style="background:#ef4444;"></span>Perlu Perbaikan</span>
                        <strong><?= $fmt($totalInvalid); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4 mb-24">
    <div class="col-xl-7">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h6 class="fw-semibold mb-1">Kompetisi Terbaru</h6>
                        <p class="dash-muted mb-0" style="font-size:12px;">Jadwal kompetisi yang terdaftar</p>
                    </div>
                    <a href="<?= base_url($linkKompetisi); ?>" class="btn btn-outline-primary-600 btn-sm">Lihat Semua</a>
                </div>
                <?php if (empty($kompetisi)) : ?>
                    <div class="dash-empty">Belum ada data kompetisi.</div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table dash-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Kompetisi</th>
                                    <th>Jadwal</th>
                                    <th>Tingkat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kompetisi as $k) : ?>
                                    <?php
                                    $start = $k['tgl_start'] ?? null;
                                    $end   = $k['tgl_end'] ?? null;
                                    $today = date('Y-m-d');
                                    if ($end && $end < $today) {
                                        $status = ['Selesai', 'dash-badge-muted'];
                                    } elseif ($start && $start > $today) {
                                        $status = ['Akan Datang', 'dash-badge-warning'];
                                    } else {
                                        $status = ['Berlangsung', 'dash-badge-success'];
                                    }
                                    $jadwal = $fmtTanggal($start);
                                    if ($end && $end !== $start) {
                                        $jadwal .= ' - ' . $fmtTanggal($end);
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold dash-strong"><?= esc($k['nama'] ?? '-'); ?></div>
                                            <small class="dash-muted"><?= esc($k['lokasi'] ?? '-'); ?></small>
                                        </td>
                                        <td style="white-space:nowrap;font-size:12px;"><?= esc($jadwal); ?></td>
                                        <td style="font-size:12px;"><?= esc($k['tingkat'] ?? '-'); ?></td>
                                        <td><span class="dash-badge <?= $status[1]; ?>"><?= $status[0]; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h6 class="fw-semibold mb-1">Rekap Medali</h6>
                        <p class="dash-muted mb-0" style="font-size:12px;">Perolehan medali atlet</p>
                    </div>
                    <a href="<?= base_url($linkPrestasi); ?>" class="dash-muted" style="font-size:12px;text-decoration:none;">Detail</a>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="dash-medal" style="background:#fffbeb;border-color:#fde68a;">
                            <strong><?= $fmt($medali['emas'] ?? 0); ?></strong>
                            <small>Emas</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="dash-medal" style="background:#f8fafc;border-color:#e2e8f0;">
                            <strong><?= $fmt($medali['perak'] ?? 0); ?></strong>
                            <small>Perak</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="dash-medal" style="background:#fff7ed;border-color:#fed7aa;">
                            <strong><?= $fmt($medali['perunggu'] ?? 0); ?></strong>
                            <small>Perunggu</small>
                        </div>
                    </div>
                </div>
                <?php if (empty($medaliCabor)) : ?>
                    <div class="dash-empty">Belum ada medali tercatat.</div>
                <?php else : ?>
                    <div class="dash-list">
                        <?php foreach ($medaliCabor as $m) : ?>
                            <div class="d-flex align-items-center justify-content-between gap-2 px-2 py-1">
                                <span class="fw-medium dash-strong-sm"><?= esc($m['nama'] ?? '-'); ?></span>
                                <span class="d-flex align-items-center gap-2" style="font-size:11px;">
                                    <span class="dash-badge" style="background:#fffbeb;color:#b45309;"><?= $fmt($m['emas'] ?? 0); ?> E</span>
                                    <span class="dash-badge" style="background:#f8fafc;color:#475569;"><?= $fmt($m['perak'] ?? 0); ?> P</span>
                                    <span class="dash-badge" style="background:#fff7ed;color:#c2410c;"><?= $fmt($m['perunggu'] ?? 0); ?> B</span>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <div class="col-xl-7">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h6 class="fw-semibold mb-1">Atlet Terbaru</h6>
                        <p class="dash-muted mb-0" style="font-size:12px;">Data atlet yang baru ditambahkan</p>
                    </div>
                    <a href="<?= base_url($linkAtlet); ?>" class="dash-muted" style="font-size:12px;text-decoration:none;">Lihat semua</a>
                </div>
                <?php if (empty($atletTerbaru)) : ?>
                    <div class="dash-empty">Belum ada data atlet.</div>
                <?php else : ?>
                    <div class="dash-list">
                        <?php foreach ($atletTerbaru as $a) : ?>
                            <?php
                            $inisial = strtoupper(mb_substr(trim($a['nama'] ?? '?'), 0, 1));
                            if ($inisial === '') {
                                $inisial = '?';
                            }
                            ?>
                            <div class="dash-list-item">
                                <span class="dash-avatar"><?= esc($inisial); ?></span>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold text-truncate dash-strong-sm"><?= esc($a['nama'] ?? '-'); ?></div>
                                    <small class="dash-muted d-block text-truncate">
                                        <?= esc($a['cabor'] ?? '-'); ?>
                                        <?php if (!empty($a['sekolah']) && $role !== 'sekolah') : ?>
                                            &middot; <?= esc($a['sekolah']); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <?= $statusBadge($a['status_calc'] ?? $a['status_final'] ?? null); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card radius-8 border-0 h-100">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h6 class="fw-semibold mb-1"><?= $role === 'sekolah' ? 'Perlu Perbaikan' : 'Perlu Divalidasi'; ?></h6>
                        <p class="dash-muted mb-0" style="font-size:12px;">
                            <?= $role === 'sekolah' ? 'Atlet dengan berkas yang dikembalikan' : 'Atlet yang menunggu tindakan validator'; ?>
                        </p>
                    </div>
                </div>
                <?php if (empty($perluTindakan)) : ?>
                    <div class="dash-empty">
                        <iconify-icon icon="solar:check-circle-outline" style="font-size:32px;color:#86efac;"></iconify-icon>
                        <div><?= $role === 'sekolah' ? 'Tidak ada berkas yang perlu diperbaiki.' : 'Tidak ada atlet yang menunggu validasi.'; ?></div>
                    </div>
                <?php else : ?>
                    <div class="dash-list">
                        <?php foreach ($perluTindakan as $a) : ?>
                            <a href="<?= base_url($linkAtlet); ?>" class="dash-list-item">
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold text-truncate dash-strong-sm"><?= esc($a['nama'] ?? '-'); ?></div>
                                    <small class="dash-muted d-block text-truncate">
                                        <?= esc($a['cabor'] ?? '-'); ?>
                                        <?php if (!empty($a['sekolah']) && $role !== 'sekolah') : ?>
                                            &middot; <?= esc($a['sekolah']); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <?= $statusBadge($a['status_calc'] ?? $a['status_final'] ?? null); ?>
                                <iconify-icon icon="solar:alt-arrow-right-linear" style="color:#94a3b8;"></iconify-icon>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ApexCharts === 'undefined') {
            return;
        }

        var caborLabels = <?= json_encode($caborLabels, $jsonFlags); ?>;
        var caborValues = <?= json_encode($caborValues, $jsonFlags); ?>;

        var caborEl = document.querySelector('#chartCabor');
        if (caborEl && caborLabels.length) {
            new ApexCharts(caborEl, {
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: 'Atlet',
                    data: caborValues
                }],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        distributed: true,
                        barHeight: '55%'
                    }
                },
                colors: ['#3b82f6', '#06b6d4', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                dataLabels: {
                    enabled: true,
                    style: { fontSize: '11px', fontWeight: 600 }
                },
                xaxis: {
                    categories: caborLabels,
                    labels: { style: { colors: '#64748b', fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#334155', fontSize: '12px' } }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                },
                legend: { show: false },
                tooltip: {
                    y: { formatter: function(v) { return v + ' atlet'; } }
                }
            }).render();
        }

        var validasiEl = document.querySelector('#chartValidasi');
        var valid = <?= (int) $totalValid; ?>;
        var pending = <?= (int) $totalPending; ?>;
        var invalid = <?= (int) $totalInvalid; ?>;
        var total = <?= (int) $totalAtlet; ?>;

        if (validasiEl) {
            new ApexCharts(validasiEl, {
                chart: {
                    type: 'donut',
                    height: 210,
                    fontFamily: 'inherit'
                },
                series: [valid, pending, invalid],
                labels: ['Valid', 'Menunggu', 'Perlu Perbaikan'],
                colors: ['#10b981', '#f59e0b', '#ef4444'],
                stroke: { width: 2, colors: ['#ffffff'] },
                legend: { show: false },
                dataLabels: { enabled: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '11px',
                                    color: '#64748b',
                                    offsetY: 18
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#0f172a',
                                    offsetY: -10
                                },
                                total: {
                                    show: true,
                                    label: 'Total Atlet',
                                    fontSize: '11px',
                                    color: '#64748b',
                                    formatter: function() { return total; }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: { formatter: function(v) { return v + ' atlet'; } }
                }
            }).render();
        }
    });
</script>

<?= $this->endSection(); ?>
