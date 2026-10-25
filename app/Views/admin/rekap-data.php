<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/page-header', [
    'pageTitle' => 'Rekap Data',
    'breadcrumb' => [
        ['label' => 'Dashboard', 'href' => base_url($role === 'admin' ? '/dashboard' : $role . '/dashboard'), 'icon' => 'solar:home-smile-angle-outline'],
        ['label' => 'Rekap Data', 'href' => null, 'icon' => 'solar:document-text-outline'],
    ],
    'actions' => [],
]); ?>

<div class="row">
    <div class="col-12">

        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="rekap-tab" data-bs-toggle="tab" data-bs-target="#rekap-pane" type="button" role="tab" aria-controls="rekap-pane" aria-selected="true">
                    <iconify-icon icon="solar:document-text-outline" class="me-1"></iconify-icon> Rekap Seluruh Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#berkas-pane" type="button" role="tab" aria-controls="berkas-pane" aria-selected="false">
                    <iconify-icon icon="solar:folder-with-files-outline" class="me-1"></iconify-icon> Export Terpilih (Data Diri & Berkas)
                </button>
            </li>
        </ul>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 fw-bold">Pilih Atlet yang Akan Diunduh:</h6>

            <div class="d-flex gap-2">
                <button class="btn btn-success fw-bold d-none align-items-center gap-2" id="btn-export-datadiri">
                    <iconify-icon icon="icon-park-solid:excel" class="fs-5"></iconify-icon> Data Diri
                </button>
                <button class="btn btn-warning text-dark fw-bold d-none align-items-center gap-2" id="btn-download-selected-zip">
                    <iconify-icon icon="ph:file-zip-duotone" class="fs-5"></iconify-icon> Berkas ZIP
                </button>
            </div>
        </div>

        <form id="form-export-datadiri" action="<?= site_url('download/datadiri-excel'); ?>" method="POST" target="_blank" class="d-none">
            <input type="hidden" name="atlet_ids" id="datadiri-atlet-ids-input">
        </form>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="rekap-pane" role="tabpanel" tabindex="0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Cabang Olahraga</label>
                                <select class="form-select select2" id="filter_cabor">
                                    <option value="">Pilih Cabor</option>
                                    <?php foreach ($cabor as $c): ?>
                                        <option value="<?= $c['id']; ?>"><?= esc($c['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenjang</label>
                                <select class="form-select select2" id="filter_jenjang">
                                    <option value="">Semua Jenjang</option>
                                    <?php foreach ($jenjang as $j): ?>
                                        <option value="<?= $j['id']; ?>"><?= esc($j['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="filter_status">
                                    <option value="">Semua</option>
                                    <option value="valid">Lengkap</option>
                                    <option value="pending">Belum</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button class="btn btn-primary" id="btn-generate">Generate Rekap</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="result-area" class="d-none">
                    <div class="card">
                        <div class="card-body">
                            <div id="summary" class="mb-3"></div>
                            <div class="mb-3">
                                <a href="#" id="btn-download-excel" class="btn btn-success">Download Excel</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="preview-table">
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
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="berkas-pane" role="tabpanel" tabindex="0">
                <div class="card mb-4 border-warning shadow-sm">
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
                            <iconify-icon icon="solar:info-circle-bold-duotone" class="fs-4"></iconify-icon>
                            <div>
                                Cari daftar atlet pada form di bawah, <strong>centang atlet yang terpilih</strong> (lintas sekolah), lalu klik tombol unduh untuk merangkum dokumen mereka ke dalam satu file .ZIP.
                            </div>
                        </div>

                        <div class="row g-2 align-items-end mb-4 bg-light p-3 rounded">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Cabor</label>
                                <select class="form-select select2" id="zip_cabor">
                                    <option value="">-- Pilih Cabor --</option>
                                    <?php foreach ($cabor as $c): ?>
                                        <option value="<?= $c['id']; ?>"><?= esc($c['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Jenjang</label>
                                <select class="form-select select2" id="zip_jenjang">
                                    <option value="">-- Semua --</option>
                                    <?php foreach ($jenjang as $j): ?>
                                        <option value="<?= $j['id']; ?>"><?= esc($j['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select class="form-select" id="zip_jk">
                                    <option value="">-- Semua --</option>
                                    <option value="L">Putra (L)</option>
                                    <option value="P">Putri (P)</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Cari Nama</label>
                                <input type="text" class="form-control" id="zip_search_nama" placeholder="Ketik nama...">
                            </div>

                            <div class="col-md-2 d-grid">
                                <button class="btn btn-primary d-flex align-items-center justify-content-center gap-1" id="btn-search-zip">
                                    <iconify-icon icon="bx:search" class="fs-5"></iconify-icon> Cari
                                </button>
                            </div>
                        </div>

                        <div id="zip-result-area" class="d-none">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Pilih Atlet yang Akan Diunduh Berkasnya:</h6>
                                <button class="btn btn-warning text-dark fw-bold d-none align-items-center gap-2" id="btn-zip-download-selected">
                                    <iconify-icon icon="ph:file-zip-duotone" class="fs-5"></iconify-icon> Unduh Berkas ZIP Terpilih
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="zip-table">
                                    <thead class="table-warning text-center align-middle">
                                        <tr>
                                            <th style="width: 50px;">
                                                <input class="form-check-input border-dark" type="checkbox" id="check-all-zip">
                                            </th>
                                            <th>Nama Atlet</th>
                                            <th>L/P</th>
                                            <th>Asal Sekolah</th>
                                            <th>Nomor/Detail</th>
                                            <th>Medali</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<form id="form-download-zip" action="<?= site_url('download/berkas-zip'); ?>" method="POST" target="_blank" class="d-none">
    <input type="hidden" name="atlet_ids" id="atlet-ids-input">
    <input type="hidden" name="cabor_id" id="zip-cabor-input">
    <input type="hidden" name="jenjang_id" id="zip-jenjang-input">
</form>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.css" />
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        // ==========================================
        // TAB 1: GENERATE REKAP DATA
        // ==========================================
        $('#btn-generate').click(function() {
            const btn = $(this);
            const cabor_id = $('#filter_cabor').val();
            const jenjang_id = $('#filter_jenjang').val();
            const status = $('#filter_status').val();

            if (!cabor_id) {
                alert('Silakan pilih cabang olahraga terlebih dahulu');
                return;
            }

            btn.prop('disabled', true).text('Generating...');

            $.ajax({
                url: "<?= site_url('download/preview'); ?>",
                method: "POST",
                dataType: "json",
                data: {
                    cabor_id: cabor_id,
                    jenjang_id: jenjang_id,
                    status: status
                },
                success: function(res) {
                    btn.prop('disabled', false).text('Generate Rekap');
                    if (res.status !== 'success') return alert(res.message);

                    $('#summary').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Cabor:</strong> ${res.meta.cabor}<br>
                            <strong>Penanggung Jawab:</strong> ${res.meta.penanggung_jawab}
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>Total:</strong> ${res.meta.total} <br>
                            <span class="text-success">Lengkap: ${res.meta.lengkap}</span> |
                            <span class="text-danger">Belum: ${res.meta.belum}</span>
                        </div>
                    </div>`);

                    $('#btn-download-excel').attr('href', "<?= site_url('download/excel'); ?>?cabor_id=" + cabor_id + "&jenjang_id=" + jenjang_id + "&status=" + status);

                    const tbody = $('#preview-table tbody');
                    tbody.empty();

                    if (res.data.length === 0) {
                        tbody.append(`<tr><td colspan="9" class="text-center text-muted">Tidak ada data</td></tr>`);
                    } else {
                        let no = 1;
                        res.data.forEach(function(row) {
                            const badge = row.verifikasi === 'Lengkap' ? 'success' : 'danger';
                            tbody.append(`
                            <tr>
                                <td class="text-center">${no++}</td>
                                <td>${escapeHtml(row.nama)}</td>
                                <td>${escapeHtml(row.jk)}</td>
                                <td>${escapeHtml(row.ttl)}</td>
                                <td>${escapeHtml(row.sekolah)}</td>
                                <td>${escapeHtml(row.cabor)}</td>
                                <td>${escapeHtml(row.nomor || '')} ${escapeHtml(row.kategori || '')}</td>
                                <td>${escapeHtml(row.jenjang)}</td>
                                <td class="text-center"><span class="badge bg-${badge}">${escapeHtml(row.verifikasi)}</span></td>
                            </tr>`);
                        });
                    }
                    $('#result-area').removeClass('d-none');
                },
                error: function() {
                    btn.prop('disabled', false).text('Generate Rekap');
                    alert('Terjadi kesalahan server');
                }
            });
        });


        // ==========================================
        // TAB 2: UNDUH BERKAS (FITUR CHECKBOX)
        // ==========================================

        // 1. Tampilkan Daftar Atlet
        $('#btn-search-zip').click(function() {
            const btn = $(this);
            const zip_cabor = $('#zip_cabor').val();
            const zip_jenjang = $('#zip_jenjang').val();
            const zip_jk = $('#zip_jk').val();
            const zip_search = $('#zip_search_nama').val();

            if (!zip_cabor) {
                alert('Silakan pilih Cabang Olahraga terlebih dahulu!');
                return;
            }

            btn.prop('disabled', true).html('<div class="spinner-border spinner-border-sm" role="status"></div>');

            $.ajax({
                url: "<?= site_url('download/rekap-atlet-file'); ?>",
                method: "POST",
                dataType: "json",
                data: {
                    cabor_id: zip_cabor,
                    jenjang_id: zip_jenjang,
                    jk: zip_jk,
                    search_nama: zip_search,
                    status: 'valid'
                },
                success: function(res) {
                    btn.prop('disabled', false).html('<iconify-icon icon="bx:search" class="fs-5"></iconify-icon> Cari');

                    if (res.status !== 'success') {
                        alert(res.message);
                        return;
                    }

                    const tbody = $('#zip-table tbody');
                    tbody.empty();

                    if (res.data.length === 0) {
                        tbody.append(`<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data atlet berprestasi untuk filter ini.</td></tr>`);
                    } else {
                        res.data.forEach(function(row) {
                            let badge = row.verifikasi === 'Lengkap' ? 'success' : 'danger';

                            let medaliBadge = '';
                            if (row.prestasi == '1') {
                                medaliBadge = `<span class="badge text-dark w-100 py-2" style="background-color: #FDDE6C;">Emas</span>`;
                            } else if (row.prestasi == '2') {
                                medaliBadge = `<span class="badge text-dark w-100 py-2" style="background-color: #E3E4E5;">Perak</span>`;
                            } else if (row.prestasi == '3') {
                                medaliBadge = `<span class="badge text-white w-100 py-2" style="background-color: #CD7F32;">Perunggu</span>`;
                            } else {
                                medaliBadge = `<span class="text-muted">-</span>`;
                            }

                            tbody.append(`
                                <tr>
                                    <td class="text-center align-middle">
                                        <input class="form-check-input border-dark check-atlet" type="checkbox" value="${escapeHtml(row.id)}">
                                    </td>
                                    <td class="fw-medium align-middle">${escapeHtml(row.nama)}</td>
                                    <td class="text-center align-middle">${escapeHtml(row.jk)}</td>
                                    <td class="align-middle">${escapeHtml(row.sekolah)}</td>
                                    <td class="align-middle">${escapeHtml(row.nomor || '')} ${escapeHtml(row.kategori || '')}</td>
                                    <td class="text-center align-middle" style="width: 110px;">${medaliBadge}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-${badge}">${escapeHtml(row.verifikasi)}</span>
                                    </td>
                                </tr>
                            `);
                        });
                    }

                    $('#zip-result-area').removeClass('d-none');
                    $('#check-all-zip').prop('checked', false);
                    toggleZipDownloadButton();
                },
                error: function() {
                    btn.prop('disabled', false).html('<iconify-icon icon="bx:search" class="fs-5"></iconify-icon> Cari');
                    alert('Terjadi kesalahan saat menarik data atlet.');
                }
            });
        });

        // 2. Logika "Check All"
        $('#check-all-zip').on('change', function() {
            $('.check-atlet').prop('checked', $(this).prop('checked'));
            toggleZipDownloadButton();
        });

        // 3. Logika Centang Individu
        $(document).on('change', '.check-atlet', function() {
            if ($('.check-atlet:checked').length == $('.check-atlet').length) {
                $('#check-all-zip').prop('checked', true);
            } else {
                $('#check-all-zip').prop('checked', false);
            }
            toggleZipDownloadButton();
        });

        // 4. Memunculkan / Menghilangkan Tombol Download
        function toggleZipDownloadButton() {
            const totalChecked = $('.check-atlet:checked').length;
            if (totalChecked > 0) {
                $('#btn-zip-download-selected').removeClass('d-none').addClass('d-flex').html(`<iconify-icon icon="ph:file-zip-duotone" class="fs-5"></iconify-icon> Berkas ZIP (${totalChecked})`);
                $('#btn-export-datadiri').removeClass('d-none').addClass('d-flex').html(`<iconify-icon icon="icon-park-solid:excel" class="fs-5"></iconify-icon> Data Diri (${totalChecked})`);
            } else {
                $('#btn-zip-download-selected').removeClass('d-flex').addClass('d-none');
                $('#btn-export-datadiri').removeClass('d-flex').addClass('d-none');
            }
        }

        // Event handler klik tombol Export Data Diri
        $('#btn-export-datadiri').click(function() {
            const selectedIds = [];
            $('.check-atlet:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Tidak ada atlet yang dipilih.');
                return;
            }

            $('#datadiri-atlet-ids-input').val(selectedIds.join(','));
            $('#form-export-datadiri').submit();
        });

        // 5. Submit Form untuk Download ZIP
        $('#btn-zip-download-selected').click(function() {
            const selectedIds = [];
            $('.check-atlet:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Tidak ada atlet yang dipilih.');
                return;
            }

            $('#atlet-ids-input').val(selectedIds.join(','));
            $('#zip-cabor-input').val($('#zip_cabor').val());
            $('#zip-jenjang-input').val($('#zip_jenjang').val());

            $('#form-download-zip').submit();
        });

        // Helper escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    });
</script>

<?= $this->endSection(); ?>
