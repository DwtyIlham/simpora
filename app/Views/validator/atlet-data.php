<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
// Perbaikan: role_id 1 = admin, 4 = validator, selainnya = sekolah
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <h6 class="fw-semibold mb-0">Data Atlet Pelajar</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= site_url($role . '/atlet/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Data Atlet Pelajar
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Data Atlet Pelajar</h5>
            </div>
            <div class="card-body gy-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">Filter Cabor</label>
                        <span class="icon align-middle">
                            <iconify-icon icon="fluent:sport-24-regular" width="24" height="24"></iconify-icon>
                        </span>
                        <div class="icon-field">
                            <select class="form-select select2" name="filter_cabor" id="filter_cabor" data-placeholder="Pilih Cabang Olahraga">
                                <option value=""></option>
                                <?php foreach ($cabor as $c): ?>
                                    <option value="<?= $c['id']; ?>" data-nama="<?= esc($c['nama']); ?>"><?= esc($c['nama']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Filter Sekolah</label>
                        <span class="icon align-middle">
                            <iconify-icon icon="icon-park-outline:school" width="20" height="20"></iconify-icon>
                        </span>
                        <div class="icon-field">
                            <select class="form-select select2" name="filter_sekolah" id="filter_sekolah" data-placeholder="Pilih Sekolah">
                                <option value=""></option>
                                <?php foreach ($sekolah as $s): ?>
                                    <option value="<?= $s['id']; ?>" data-nama="<?= esc($s['nama']); ?>"><?= esc($s['nama']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Filter Status</label>
                        <span class="icon align-middle">
                            <iconify-icon icon="icon-park-outline:validation" width="20" height="20"></iconify-icon>
                        </span>
                        <div class="icon-field">
                            <select class="form-select" name="filter_status" id="filter_status">
                                <option selected>- Semua -</option>
                                <option value="sudah" data-status="sudah">Sudah</option>
                                <option value="belum" data-status="belum">Belum</option>
                                <option value="perbaikan" data-status="perbaikan">Perlu Perbaikan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">No.</th>
                            <th class="text-center" scope="col">Aksi</th>
                            <th class="text-center" scope="col">Validasi</th>
                            <th class="text-center" scope="col">Nama</th>
                            <th class="text-center" scope="col">Sekolah</th>
                            <th class="text-center" scope="col">JK</th>
                            <th class="text-center" scope="col">Cabor</th>
                            <th class="text-center" scope="col">Nomor Lomba</th>
                            <th class="text-center" scope="col">Jenjang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        $jenis_dok = [
                            'akte_status',
                            'foto_status',
                            'ktp_kia_kk_status',
                            'nisn_status',
                            'ijazah_status',
                            'suket_status',
                        ];

                        foreach ($atlet as $a):

                            // tentukan apakah ijazah wajib
                            $bentuk = $a['bentuk_pendidikan'] ?? '';
                            $isIjazahRequired = !in_array($bentuk, ['SD', 'MI']);

                            $errorCount = 0;
                            $hasInvalid = false;
                            $hasPending = false;

                            foreach ($jenis_dok as $jd) {

                                // skip ijazah jika tidak wajib (SD / MI)
                                if ($jd === 'ijazah_status' && !$isIjazahRequired) {
                                    continue;
                                }

                                $status = $a[$jd] ?? null;

                                if ($status === 'invalid') {
                                    $hasInvalid = true;
                                    $errorCount++;
                                } elseif ($status === 'pending') {
                                    $hasPending = true;
                                    $errorCount++;
                                } elseif ($status === 'valid') {
                                    // valid, tidak menambah error
                                } else {
                                    // Status kosong / tidak dikenal = belum pernah divalidasi.
                                    // Jangan dianggap "Sudah".
                                    $hasPending = true;
                                    $errorCount++;
                                }
                            }

                            // tentukan status akhir
                            $isNotValid = $hasInvalid
                                ? 'Perlu Perbaikan'
                                : ($hasPending ? 'Belum' : 'Sudah');
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                        data-id="<?= $a['id']; ?>"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="Detail dan Validasi"
                                        class="view-atlet w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="hugeicons:validation-approval"></iconify-icon>
                                    </a>

                                    <a href="<?= site_url('validator/atlet/edit/') . $a['id']; ?>"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="Edit Data"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <a id="<?= $a['id']; ?>"
                                        data-bs-toggle="tooltip"
                                        data-bs-title="Hapus"
                                        class="delete-atlet w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>

                                <td class="text-center" data-search="<?= $isNotValid === 'Perlu Perbaikan' ? 'perbaikan' : ($isNotValid === 'Belum' ? 'belum' : 'sudah') ?>">
                                    <span
                                        class="badge badge-status-depan <?= $isNotValid === 'Belum' ? 'bg-warning text-dark' : ($isNotValid === 'Sudah' ? 'bg-success text-light' : 'bg-danger text-light') ?>"
                                        data-id="<?= $a['id']; ?>">
                                        <?= $isNotValid ?>
                                    </span>
                                </td>

                                <!-- data -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('public/uploads/atlet/file_foto/' . ($a['file_foto'] ?? 'default.png')); ?>"
                                            class="w-40-px h-40-px rounded-circle me-12">

                                        <span>
                                            <?= htmlspecialchars($a['nama'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>
                                </td>

                                <td data-search="<?= htmlspecialchars($a['sekolah'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($a['sekolah'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center"><?= htmlspecialchars($a['jenis_kelamin'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td data-search="<?= htmlspecialchars($a['cabor'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($a['cabor'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars(trim(($a['nomor_cabor'] ?? '') . ' ' . ($a['jenis'] ?? '') . ' ' . ($a['detail'] ?? '') . ' ' . ($a['kategori'] ?? '')) ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($a['jenjang'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>

                            </tr>

                        <?php
                            $no++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('partials/atlet-detail-modal', [
    'canValidate' => true,
    'role'        => 'validator',
]); ?>

<script>
    $(document).ready(function() {
        let table = new DataTable('#dataTable', {
        responsive: true
    });

    // hanya sekali
    table.on('draw.dt', function() {

        // re-init tooltip
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        // re-render iconify
        if (window.Iconify) {
            requestAnimationFrame(() => {
                Iconify.scan(document.body);
            });
        }
    });

    function escapeRegex(value) {
        return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    $('#filter_cabor, #filter_sekolah, #filter_status').on('change', function() {

        let cabor = $('#filter_cabor option:selected').data('nama');
        let sekolah = $('#filter_sekolah option:selected').data('nama');
        let status = $('#filter_status option:selected').data('status');

        table.columns().search("");

        // Index kolom: 2 = Validasi, 4 = Sekolah, 6 = Cabor
        if (cabor) {
            table.column(6).search('^' + escapeRegex(cabor) + '$', true, false);
        }

        if (sekolah) {
            table.column(4).search('^' + escapeRegex(sekolah) + '$', true, false);
        }

        if (status) {
            table.column(2).search('^' + escapeRegex(status) + '$', true, false);
        }

        table.draw();
    });

    function statusMeta(status) {
        if (status === 'valid') {
            return { label: 'Valid', cls: 'bg-success text-light' };
        }
        if (status === 'invalid') {
            return { label: 'Perlu Perbaikan', cls: 'bg-danger text-light' };
        }
        return { label: 'Belum Dicek', cls: 'bg-warning text-dark' };
    }

    function updateRowBadge(atletId, statusFinal) {
        const $badge = $('.badge-status-depan[data-id="' + atletId + '"]');
        if (statusFinal === 'valid') {
            $badge.removeClass().addClass('badge badge-status-depan bg-success text-light').text('Sudah');
        } else if (statusFinal === 'invalid') {
            $badge.removeClass().addClass('badge badge-status-depan bg-danger text-light').text('Perlu Perbaikan');
        } else {
            $badge.removeClass().addClass('badge badge-status-depan bg-warning text-dark').text('Belum');
        }
    }

    function refreshVerification(atletId) {
        const bentuk = $('#viewAtletModal').data('bentuk') || '';

        return $.get(window.ATLET_VALIDASI_URL, { atletID: atletId }).then(function(data) {
            data = data || {};

            window.getRequiredDocs(bentuk).forEach(function(doc) {
                window.setDocCardStatus(doc.type, data[doc.key] || 'pending');
            });

            window.renderVerificationSummary(data, bentuk);

            const statusFinal = window.hitungStatusFinal(data, bentuk);
            return $.post(window.ATLET_SET_VALID_URL, {
                atletID: atletId,
                status: statusFinal
            }).then(function() {
                return statusFinal;
            });
        });
    }

    // Validasi Semua dari toolbar modal (satu request, satu loader)
    $('#btnValidateAll').off('click').on('click', function() {
        const atletId = $('#viewAtletModal').data('atlet-id');
        const btn = $(this);
        if (!atletId || btn.prop('disabled')) return;

        const originalHtml = btn.data('original-html') || btn.html();
        btn.data('original-html', originalHtml);
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Memproses...'
        );

        const bentuk = $('#viewAtletModal').data('bentuk') || '';

        $.ajax({
                url: window.ATLET_VALIDASI_SEMUA_URL,
                method: 'GET',
                data: { atletID: atletId },
                global: false
            })
            .done(function(res) {
                res = res || {};
                const validasi = res.validasi || {};

                window.getRequiredDocs(bentuk).forEach(function(doc) {
                    window.setDocCardStatus(doc.type, validasi[doc.key] || 'pending');
                });
                window.renderVerificationSummary(validasi, bentuk);

                if (res.status_final) {
                    updateRowBadge(atletId, res.status_final);
                }

                window.showGalleryToast('Semua dokumen berhasil divalidasi.', 'success');
            })
            .fail(function() {
                window.showGalleryToast('Terjadi kesalahan saat memproses validasi.', 'danger');
            })
            .always(function() {
                btn.prop('disabled', false).html(originalHtml);
            });
    });

    // view detail atlet
    $(document).on('click', '.view-atlet', function() {
        const atletId = $(this).data('id');

        function detectImageSize() {
            document.querySelectorAll('.view-img:not([data-pswp-width])').forEach(a => {
                const img = new Image();
                img.src = a.href;
                img.onload = function() {
                    a.setAttribute('data-pswp-width', this.width);
                    a.setAttribute('data-pswp-height', this.height);
                };
            });
        }

        $.ajax({
            url: window.ATLET_DETAIL_URL,
            method: "GET",
            data: { id: atletId },
            success: function(res) {
                if (!res || res.status === 'error' || !res.data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal memuat detail atlet',
                        text: (res && res.message) ? res.message : 'Data atlet tidak ditemukan.'
                    });
                    return;
                }

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
                    akte_status: '<?= base_url('public/uploads/atlet/file_akte/'); ?>',
                    foto_status: '<?= base_url('public/uploads/atlet/file_foto/'); ?>',
                    ktp_kia_kk_status: '<?= base_url('public/uploads/atlet/file_ktp_kia_kk/'); ?>',
                    nisn_status: '<?= base_url('public/uploads/atlet/file_nisn/'); ?>',
                    ijazah_status: '<?= base_url('public/uploads/atlet/file_ijazah/'); ?>',
                    suket_status: '<?= base_url('public/uploads/atlet/file_suket/'); ?>'
                };

                let html = "";
                window.getRequiredDocs(bentuk).forEach(function(doc) {
                    const file = res.data[fileMap[doc.key]];
                    const status = statusValidasi(doc.key);

                    if (file) {
                        html += templateFile(doc.label, folderMap[doc.key] + file, status, doc.type, atletId, 'validator');
                    } else {
                        html += templateMissing(doc.label, doc.type, status);
                    }
                });

                $("#file-gallery").html(html);
                window.renderVerificationSummary(validasi, bentuk);
                detectImageSize();
                window.reInitGallery();
            }
        });
    });
    });
</script>

<?= $this->endSection(); ?>
