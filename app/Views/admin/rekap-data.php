<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId          = (string) (session('user')['role_id'] ?? '');
$role            = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
$isValidator     = $isValidator ?? false;
$summary         = $summary ?? ['total' => 0, 'lengkap' => 0, 'pending' => 0, 'invalid' => 0, 'belum_dicek' => 0];
$defaultCaborId  = $defaultCaborId ?? null;
$assignedCaborIds = $assignedCaborIds ?? [];
$canGenerate     = ! $isValidator || ! empty($assignedCaborIds);
$caborLabel      = $isValidator ? 'Semua Cabor Saya' : 'Semua Cabor';
?>

<?= $this->include('partials/page-header', [
    'pageTitle' => 'Rekap Data',
    'breadcrumb' => [
        ['label' => 'Dashboard', 'href' => base_url($role === 'admin' ? '/dashboard' : $role . '/dashboard'), 'icon' => 'solar:home-smile-angle-outline'],
        ['label' => 'Rekap Data', 'href' => null, 'icon' => 'solar:document-text-outline'],
    ],
    'actions' => [],
]); ?>

<style>
    .rekap-stat-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.35rem;
        flex: 0 0 44px;
    }

    .rekap-toolbar {
        gap: .5rem;
    }

    .rekap-table thead th {
        white-space: nowrap;
        font-size: .78rem;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .rekap-table td {
        vertical-align: middle;
        font-size: .875rem;
    }

    .rekap-tabs .nav-link {
        font-weight: 600;
    }

    .rekap-empty {
        padding: 2.5rem 1rem;
    }

    @media (max-width: 575.98px) {
        .rekap-toolbar {
            width: 100%;
        }

        .rekap-toolbar > * {
            flex: 1 1 100%;
        }

        .rekap-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .rekap-tabs::-webkit-scrollbar {
            display: none;
        }

        .rekap-tabs .nav-link {
            white-space: nowrap;
        }
    }
</style>

<?php if ($isValidator && empty($assignedCaborIds)): ?>
    <div class="alert alert-warning d-flex align-items-start gap-2" role="alert">
        <iconify-icon icon="solar:danger-triangle-bold-duotone" class="fs-4 mt-1"></iconify-icon>
        <div>
            <strong>Akun validator belum memiliki cabang olahraga.</strong><br>
            Hubungi administrator untuk menugaskan cabang olahraga sebelum menggunakan halaman rekap data.
        </div>
    </div>
<?php elseif ($isValidator): ?>
    <div class="alert alert-info d-flex align-items-start gap-2" role="alert">
        <iconify-icon icon="solar:info-circle-bold-duotone" class="fs-4 mt-1"></iconify-icon>
        <div>
            Data yang tampil dan dapat diunduh hanya mencakup cabang olahraga yang ditugaskan kepada akun Anda.
        </div>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="rekap-stat-icon bg-primary-subtle text-primary">
                    <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
                </span>
                <div>
                    <div class="text-muted small">Total Atlet</div>
                    <div class="fs-4 fw-bold lh-1"><?= number_format($summary['total'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="rekap-stat-icon bg-success-subtle text-success">
                    <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                </span>
                <div>
                    <div class="text-muted small">Lengkap</div>
                    <div class="fs-4 fw-bold lh-1"><?= number_format($summary['lengkap'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="rekap-stat-icon bg-warning-subtle text-warning">
                    <iconify-icon icon="solar:clock-circle-bold-duotone"></iconify-icon>
                </span>
                <div>
                    <div class="text-muted small">Belum Lengkap</div>
                    <div class="fs-4 fw-bold lh-1"><?= number_format($summary['pending'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="rekap-stat-icon bg-danger-subtle text-danger">
                    <iconify-icon icon="solar:close-circle-bold-duotone"></iconify-icon>
                </span>
                <div>
                    <div class="text-muted small">Tidak Valid</div>
                    <div class="fs-4 fw-bold lh-1"><?= number_format($summary['invalid'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <span class="rekap-stat-icon bg-secondary-subtle text-secondary">
                    <iconify-icon icon="solar:question-circle-bold-duotone"></iconify-icon>
                </span>
                <div>
                    <div class="text-muted small">Belum Dicek</div>
                    <div class="fs-4 fw-bold lh-1"><?= number_format($summary['belum_dicek'], 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-muted small mb-3">
    Ringkasan status akhir validasi atlet<?= $isValidator ? ' pada cabang olahraga yang ditugaskan' : ''; ?>.
</div>

<ul class="nav nav-tabs mb-4 rekap-tabs" id="rekapTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="rekap-tab" data-bs-toggle="tab" data-bs-target="#rekap-pane" type="button" role="tab" aria-controls="rekap-pane" aria-selected="true">
            <iconify-icon icon="solar:document-text-outline" class="me-1"></iconify-icon>
            <span class="d-none d-md-inline">Rekap Seluruh Data</span><span class="d-md-none">Rekap</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#berkas-pane" type="button" role="tab" aria-controls="berkas-pane" aria-selected="false">
            <iconify-icon icon="solar:folder-with-files-outline" class="me-1"></iconify-icon>
            <span class="d-none d-md-inline">Export Data Diri &amp; Berkas</span><span class="d-md-none">Export Berkas</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="rekapTabContent">

    <!-- TAB 1: REKAP SELURUH DATA -->
    <div class="tab-pane fade show active" id="rekap-pane" role="tabpanel" tabindex="0">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" for="filter_cabor">Cabang Olahraga</label>
                        <select class="form-select select2" id="filter_cabor">
                            <option value=""><?= esc($caborLabel) ?></option>
                            <?php foreach ($cabor as $c): ?>
                                <option value="<?= esc($c['id']); ?>" <?= (string) $defaultCaborId === (string) $c['id'] ? 'selected' : ''; ?>>
                                    <?= esc($c['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="filter_jenjang">Jenjang</label>
                        <select class="form-select select2" id="filter_jenjang">
                            <option value="">Semua</option>
                            <?php foreach ($jenjang as $j): ?>
                                <option value="<?= esc($j['id']); ?>"><?= esc($j['nama']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="filter_status">Status</label>
                        <select class="form-select" id="filter_status">
                            <option value="">Semua Status</option>
                            <option value="valid">Lengkap</option>
                            <option value="pending">Belum Lengkap</option>
                            <option value="invalid">Tidak Valid</option>
                            <option value="unchecked">Belum Dicek</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="filter_search_nama">Cari Nama Atlet</label>
                        <input type="text" class="form-control" id="filter_search_nama" placeholder="Ketik nama atlet..." autocomplete="off">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary d-flex align-items-center justify-content-center gap-1" id="btn-generate" <?= $canGenerate ? '' : 'disabled'; ?>>
                            <iconify-icon icon="solar:refresh-circle-bold-duotone" class="fs-5"></iconify-icon> Generate
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="result-area" class="d-none">
            <div class="card">
                <div class="card-header bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h6 class="mb-0 fw-bold">Hasil Rekapitulasi</h6>
                        <div class="text-muted small" id="preview_count_note"></div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <span class="input-group-text bg-transparent"><iconify-icon icon="bx:search"></iconify-icon></span>
                            <input type="text" class="form-control" id="preview_search" placeholder="Filter tabel...">
                        </div>
                        <a href="#" id="btn-download-excel" class="btn btn-success btn-sm">
                            <iconify-icon icon="icon-park-solid:excel" class="me-1"></iconify-icon> Download Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="summary" class="mb-3"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover rekap-table mb-0" id="preview-table">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>L/P</th>
                                    <th>TTL</th>
                                    <th>Sekolah</th>
                                    <th>Cabor</th>
                                    <th>Nomor</th>
                                    <th>Jenjang</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3" id="preview-pager">
                        <div class="text-muted small" id="preview_page_note"></div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="preview-prev">
                                <iconify-icon icon="solar:alt-arrow-left-linear"></iconify-icon> Sebelumnya
                            </button>
                            <span class="small" id="preview_page_label"></span>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="preview-next">
                                Berikutnya <iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: EXPORT DATA DIRI & BERKAS -->
    <div class="tab-pane fade" id="berkas-pane" role="tabpanel" tabindex="0">
        <div class="card mb-4">
            <div class="card-body">
                <div class="alert alert-warning d-flex align-items-start gap-2 mb-4" role="alert">
                    <iconify-icon icon="solar:info-circle-bold-duotone" class="fs-4 mt-1"></iconify-icon>
                    <div>
                        Daftar di bawah berisi atlet yang memiliki prestasi/medali. Centang atlet yang ingin diunduh
                        (boleh lintas sekolah), lalu pilih <strong>Data Diri</strong> atau <strong>Berkas ZIP</strong>.
                    </div>
                </div>

                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="zip_cabor">Cabang Olahraga</label>
                        <select class="form-select select2" id="zip_cabor">
                            <option value=""><?= esc($caborLabel) ?></option>
                            <?php foreach ($cabor as $c): ?>
                                <option value="<?= esc($c['id']); ?>" <?= (string) $defaultCaborId === (string) $c['id'] ? 'selected' : ''; ?>>
                                    <?= esc($c['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold" for="zip_jenjang">Jenjang</label>
                        <select class="form-select select2" id="zip_jenjang">
                            <option value="">Semua</option>
                            <?php foreach ($jenjang as $j): ?>
                                <option value="<?= esc($j['id']); ?>"><?= esc($j['nama']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold" for="zip_jk">Kategori</label>
                        <select class="form-select" id="zip_jk">
                            <option value="">Semua</option>
                            <option value="L">Putra (L)</option>
                            <option value="P">Putri (P)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold" for="zip_status">Status</label>
                        <select class="form-select" id="zip_status">
                            <option value="">Semua Status</option>
                            <option value="valid" selected>Lengkap</option>
                            <option value="pending">Belum Lengkap</option>
                            <option value="invalid">Tidak Valid</option>
                            <option value="unchecked">Belum Dicek</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold" for="zip_search_nama">Cari Nama</label>
                        <input type="text" class="form-control" id="zip_search_nama" placeholder="Ketik nama..." autocomplete="off">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button class="btn btn-primary" id="btn-search-zip" title="Cari atlet" <?= $canGenerate ? '' : 'disabled'; ?>>
                            <iconify-icon icon="bx:search" class="fs-5"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="zip-result-area" class="d-none">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h6 class="mb-0 fw-bold">Pilih Atlet</h6>
                            <div class="text-muted small" id="zip_count_note"></div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2 rekap-toolbar">
                            <span class="badge bg-light text-dark border" id="zip-selected-count">0 atlet dipilih</span>
                            <button class="btn btn-success btn-sm d-inline-flex align-items-center gap-1" id="btn-export-datadiri" disabled>
                                <iconify-icon icon="icon-park-solid:excel" class="fs-5"></iconify-icon> Data Diri
                            </button>
                            <button class="btn btn-warning text-dark btn-sm d-inline-flex align-items-center gap-1" id="btn-zip-download-selected" disabled>
                                <iconify-icon icon="ph:file-zip-duotone" class="fs-5"></iconify-icon> Berkas ZIP
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered rekap-table mb-0" id="zip-table">
                            <thead class="table-warning text-center align-middle">
                                <tr>
                                    <th style="width: 50px;">
                                        <input class="form-check-input border-dark" type="checkbox" id="check-all-zip" aria-label="Pilih semua atlet">
                                    </th>
                                    <th>Nama Atlet</th>
                                    <th>L/P</th>
                                    <th>Asal Sekolah</th>
                                    <th>Nomor/Detail</th>
                                    <th>Medali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-export-datadiri" action="<?= site_url('download/datadiri-excel'); ?>" method="POST" target="_blank" class="d-none">
    <input type="hidden" name="atlet_ids" id="datadiri-atlet-ids-input">
</form>

<form id="form-download-zip" action="<?= site_url('download/berkas-zip'); ?>" method="POST" target="_blank" class="d-none">
    <input type="hidden" name="atlet_ids" id="atlet-ids-input">
    <input type="hidden" name="cabor_id" id="zip-cabor-input">
    <input type="hidden" name="jenjang_id" id="zip-jenjang-input">
</form>

<script>
    $(function () {
        const canGenerate = <?= $canGenerate ? 'true' : 'false'; ?>;
        const previewUrl  = "<?= site_url('download/preview'); ?>";
        const excelUrl    = "<?= site_url('download/excel'); ?>";
        const zipUrl      = "<?= site_url('download/rekap-atlet-file'); ?>";

        function notifyError(message) {
            if (window.Swal) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: message || 'Terjadi kesalahan.' });
            } else {
                alert(message || 'Terjadi kesalahan.');
            }
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }

        function verificationBadge(verifikasi) {
            const styles = {
                'Lengkap': 'bg-success',
                'Belum Lengkap': 'bg-warning text-dark',
                'Tidak Valid': 'bg-danger',
                'Belum Dicek': 'bg-secondary'
            };
            const cls = styles[verifikasi] || 'bg-secondary';
            return `<span class="badge ${cls}">${escapeHtml(verifikasi)}</span>`;
        }

        function medalBadge(prestasi) {
            if (String(prestasi) === '1') {
                return '<span class="badge text-dark w-100 py-2" style="background-color:#FDDE6C;">Emas</span>';
            }
            if (String(prestasi) === '2') {
                return '<span class="badge text-dark w-100 py-2" style="background-color:#E3E4E5;">Perak</span>';
            }
            if (String(prestasi) === '3') {
                return '<span class="badge text-white w-100 py-2" style="background-color:#CD7F32;">Perunggu</span>';
            }
            return '<span class="text-muted">-</span>';
        }

        // ==========================================
        // TAB 1: GENERATE REKAP DATA
        // ==========================================
        let currentPage = 1;
        let totalPages  = 1;
        let totalRows   = 0;
        let lastParams  = null;

        function updatePager(meta, shownRows) {
            const page  = Number(meta.page || 1);
            const pages = Number(meta.total_pages || 1);

            currentPage = page;
            totalPages  = pages;
            totalRows   = Number(meta.total || 0);

            $('#preview-pager').toggle(pages > 1);
            $('#preview_page_note').text('Menampilkan ' + shownRows + ' dari ' + Number(meta.total || 0) + ' baris setelah filter');
            $('#preview_page_label').text('Halaman ' + page + ' / ' + pages);
            $('#preview-prev').prop('disabled', page <= 1);
            $('#preview-next').prop('disabled', page >= pages);
        }

        function loadPreview(page) {
            if (!canGenerate) {
                notifyError('Akun Anda belum memiliki cabang olahraga.');
                return;
            }

            if (!lastParams) {
                lastParams = {
                    cabor_id:    $('#filter_cabor').val(),
                    jenjang_id:  $('#filter_jenjang').val(),
                    status:      $('#filter_status').val(),
                    search_nama: $('#filter_search_nama').val().trim()
                };
            }

            const btn      = $('#btn-generate');
            const original = btn.data('original-html') || btn.html();
            btn.data('original-html', original);
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

            $.ajax({
                url: previewUrl,
                method: 'POST',
                dataType: 'json',
                data: $.extend({}, lastParams, { page: page })
            }).done(function (res) {
                if (!res || res.status !== 'success') {
                    notifyError(res && res.message ? res.message : 'Gagal mengambil data rekap.');
                    return;
                }

                const meta = res.meta || {};
                const rows = res.data || [];
                const tbody = $('#preview-table tbody').empty();

                // Halaman kosong (mis. karena filter berubah): mundur ke halaman yang ada isinya.
                if (rows.length === 0 && Number(meta.total || 0) > 0 && Number(meta.page || 1) > 1) {
                    loadPreview(Number(meta.page) - 1);
                    return;
                }

                $('#summary').html(`
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-7">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-primary">${escapeHtml(meta.cabor || '-')}</span>
                                <span class="badge bg-light text-dark border">Jenjang: ${escapeHtml(meta.jenjang || 'Semua')}</span>
                            </div>
                            <div class="text-muted small">
                                Penanggung jawab: <strong>${escapeHtml(meta.penanggung_jawab || '-')}</strong>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex flex-wrap justify-content-lg-end gap-2 small">
                                <span class="badge bg-success">Lengkap: ${Number(meta.lengkap || 0)}</span>
                                <span class="badge bg-warning text-dark">Belum Lengkap: ${Number(meta.belum || 0)}</span>
                                <span class="badge bg-danger">Tidak Valid: ${Number(meta.tidak_valid || 0)}</span>
                                <span class="badge bg-secondary">Belum Dicek: ${Number(meta.belum_dicek || 0)}</span>
                            </div>
                        </div>
                    </div>`);

                $('#btn-download-excel')
                    .attr('href', excelUrl + '?' + $.param(lastParams))
                    .toggleClass('disabled', Number(meta.total || 0) === 0)
                    .attr('aria-disabled', Number(meta.total || 0) === 0 ? 'true' : 'false');

                if (rows.length === 0) {
                    tbody.append('<tr><td colspan="9" class="text-center text-muted rekap-empty">Tidak ada data yang sesuai dengan filter.</td></tr>');
                } else {
                    rows.forEach(function (row, index) {
                        tbody.append(`
                            <tr data-row="1">
                                <td class="text-center">${row.no || (index + 1)}</td>
                                <td class="fw-medium">${escapeHtml(row.nama)}</td>
                                <td class="text-center">${escapeHtml(row.jk)}</td>
                                <td>${escapeHtml(row.ttl)}</td>
                                <td>${escapeHtml(row.sekolah)}</td>
                                <td>${escapeHtml(row.cabor)}</td>
                                <td>${escapeHtml((row.nomor || '') + ' ' + (row.kategori || ''))}</td>
                                <td>${escapeHtml(row.jenjang)}</td>
                                <td class="text-center">${verificationBadge(row.verifikasi)}</td>
                            </tr>`);
                    });
                }

                $('#preview_search').val('');
                $('#preview_count_note').text(rows.length + ' baris data');
                updatePager(meta, rows.length);
                $('#result-area').removeClass('d-none');
            }).fail(function () {
                notifyError('Terjadi kesalahan saat menghubungi server.');
            }).always(function () {
                btn.prop('disabled', false).html(original);
            });
        }

        $('#btn-generate').on('click', function () {
            lastParams = null;
            loadPreview(1);
        });

        $('#preview-prev').on('click', function () {
            if (currentPage > 1) loadPreview(currentPage - 1);
        });

        $('#preview-next').on('click', function () {
            if (currentPage < totalPages) loadPreview(currentPage + 1);
        });

        // Filter cepat pada tabel hasil rekap (hanya baris pada halaman yang tampil).
        $('#preview_search').on('input', function () {
            const keyword = $(this).val().toLowerCase().trim();
            const rows = $('#preview-table tbody tr[data-row]');
            let visible = 0;

            rows.each(function () {
                const cells = $(this).find('td');
                const haystack = [
                    cells.eq(1).text(),
                    cells.eq(4).text(),
                    cells.eq(5).text(),
                    cells.eq(6).text(),
                    cells.eq(7).text()
                ].join(' ').toLowerCase();
                const show = keyword === '' || haystack.indexOf(keyword) !== -1;
                $(this).toggle(show);
                if (show) {
                    visible++;
                }
            });

            $('#preview_count_note').text(visible + ' dari ' + rows.length + ' baris pada halaman ini' +
                (totalPages > 1 ? ' (total data setelah filter: ' + totalRows + ')' : ''));
        });

        // ==========================================
        // TAB 2: UNDUH DATA DIRI & BERKAS
        // ==========================================
        function toggleZipButtons() {
            const checked = $('.check-atlet:checked').length;
            const total   = $('.check-atlet').length;

            $('#check-all-zip')
                .prop('checked', total > 0 && checked === total)
                .prop('indeterminate', checked > 0 && checked < total);

            $('#zip-selected-count').text(checked + ' atlet dipilih');
            $('#btn-export-datadiri')
                .prop('disabled', checked === 0)
                .html('<iconify-icon icon="icon-park-solid:excel" class="fs-5"></iconify-icon> Data Diri' + (checked ? ' (' + checked + ')' : ''));
            $('#btn-zip-download-selected')
                .prop('disabled', checked === 0)
                .html('<iconify-icon icon="ph:file-zip-duotone" class="fs-5"></iconify-icon> Berkas ZIP' + (checked ? ' (' + checked + ')' : ''));
        }

        $('#btn-search-zip').on('click', function () {
            if (!canGenerate) {
                notifyError('Akun Anda belum memiliki cabang olahraga.');
                return;
            }

            const btn      = $(this);
            const original = btn.html();

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: zipUrl,
                method: 'POST',
                dataType: 'json',
                data: {
                    cabor_id:    $('#zip_cabor').val(),
                    jenjang_id:  $('#zip_jenjang').val(),
                    jk:          $('#zip_jk').val(),
                    status:      $('#zip_status').val(),
                    search_nama: $('#zip_search_nama').val().trim()
                }
            }).done(function (res) {
                if (!res || res.status !== 'success') {
                    notifyError(res && res.message ? res.message : 'Gagal mengambil data atlet.');
                    return;
                }

                const rows = res.data || [];
                const tbody = $('#zip-table tbody').empty();

                if (rows.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center text-muted rekap-empty">Tidak ada atlet berprestasi yang sesuai dengan filter.</td></tr>');
                } else {
                    rows.forEach(function (row) {
                        tbody.append(`
                            <tr>
                                <td class="text-center align-middle">
                                    <input class="form-check-input border-dark check-atlet" type="checkbox" value="${escapeHtml(row.id)}" aria-label="Pilih ${escapeHtml(row.nama)}">
                                </td>
                                <td class="fw-medium align-middle">${escapeHtml(row.nama)}</td>
                                <td class="text-center align-middle">${escapeHtml(row.jk)}</td>
                                <td class="align-middle">${escapeHtml(row.sekolah)}</td>
                                <td class="align-middle">${escapeHtml((row.nomor || '') + ' ' + (row.kategori || ''))}</td>
                                <td class="text-center align-middle" style="width: 110px;">${medalBadge(row.prestasi)}</td>
                                <td class="text-center align-middle">${verificationBadge(row.verifikasi)}</td>
                            </tr>`);
                    });
                }

                $('#zip_count_note').text(rows.length + ' atlet berprestasi');
                $('#zip-result-area').removeClass('d-none');
                $('#check-all-zip').prop('checked', false).prop('indeterminate', false);
                toggleZipButtons();
            }).fail(function () {
                notifyError('Terjadi kesalahan saat menarik data atlet.');
            }).always(function () {
                btn.prop('disabled', false).html(original);
            });
        });

        $('#zip_search_nama').on('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                $('#btn-search-zip').trigger('click');
            }
        });

        $('#check-all-zip').on('change', function () {
            $('.check-atlet').prop('checked', $(this).prop('checked'));
            toggleZipButtons();
        });

        $(document).on('change', '.check-atlet', toggleZipButtons);

        function selectedAtletIds() {
            return $('.check-atlet:checked').map(function () {
                return $(this).val();
            }).get();
        }

        $('#btn-export-datadiri').on('click', function () {
            const ids = selectedAtletIds();
            if (ids.length === 0) {
                notifyError('Pilih minimal satu atlet terlebih dahulu.');
                return;
            }

            $('#datadiri-atlet-ids-input').val(ids.join(','));
            $('#form-export-datadiri').trigger('submit');
        });

        $('#btn-zip-download-selected').on('click', function () {
            const ids = selectedAtletIds();
            if (ids.length === 0) {
                notifyError('Pilih minimal satu atlet terlebih dahulu.');
                return;
            }

            $('#atlet-ids-input').val(ids.join(','));
            $('#zip-cabor-input').val($('#zip_cabor').val());
            $('#zip-jenjang-input').val($('#zip_jenjang').val());
            $('#form-download-zip').trigger('submit');
        });
    });
</script>

<?= $this->endSection(); ?>
