<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\format_tgl;
use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                <?= $title; ?>
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">SILAGAPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom pb-3">
                <h5 class="card-title mb-0" id="tableTitle"><?= $title; ?></h5>
            </div>
            <div class="card-body table-responsive pt-3">
                <div class="row">
                    <div class="row g-2 align-items-end mb-4 bg-light p-3 rounded">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kompetisi</label>
                            <select id="filterKompetisi" class="form-select">
                                <option value="">-- Pilih Kompetisi --</option>
                                <?php foreach ($kompetisi as $k): ?>
                                    <option value="<?= $k['id']; ?>" <?= $k['id'] == '1' ? 'selected' : ''; ?>><?= $k['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Jenjang</label>
                            <select id="filterBentuk" class="form-select">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="1" selected>Usia Dini</option>
                                <option value="2">Pra Remaja</option>
                                <option value="3">Remaja</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Cari Sekolah</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><iconify-icon icon="bx:search"></iconify-icon></span>
                                <input type="text" id="filterSearch" class="form-control" placeholder="Ketik nama sekolah...">
                            </div>
                        </div>

                        <div class="col-md-3 d-flex flex-wrap gap-2 align-content-start">
                            <div class="d-flex w-100 gap-2">
                                <button id="btnFilter" class="btn btn-primary w-50 d-flex align-items-center justify-content-center gap-1">
                                    <iconify-icon icon="line-md:filter"></iconify-icon> Filter
                                </button>
                                <button id="btnReset" class="btn btn-outline-secondary w-50">
                                    Reset
                                </button>
                            </div>
                            <div class="d-flex w-100 gap-2">
                                <button id="btnExportExcel" class="btn btn-success w-50 d-flex align-items-center justify-content-center gap-1">
                                    <iconify-icon icon="icon-park-solid:excel"></iconify-icon> Excel
                                </button>
                                <button id="btnExportPdf" class="btn btn-danger w-50 d-flex align-items-center justify-content-center gap-1">
                                    <iconify-icon icon="bxs:file-pdf"></iconify-icon> PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <table id="tableData" class="display table table-bordered table-hover table-striped dataTable" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th>Sekolah</th>
                                <th class="text-center" style="width: 10%">Emas</th>
                                <th class="text-center" style="width: 10%">Perak</th>
                                <th class="text-center" style="width: 10%">Perunggu</th>
                                <th class="text-center" style="width: 10%">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <iconify-icon icon="solar:info-circle-outline" class="text-4xl mb-2"></iconify-icon><br>
                                    Silakan lengkapi pilihan Kompetisi dan Jenjang Pendidikan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    $(document).ready(function() {
        function loadJurnalMedali() {
            let kompetisi_id = $('#filterKompetisi').val();
            let jenjang_id = $('#filterBentuk').val();
            let search = $('#filterSearch').val();
            let teksJenjang = $('#filterBentuk option:selected').text();
            let teksKompetisi = $('#filterKompetisi option:selected').text();

            // Update UI Title biar user tahu sedang lihat data apa
            if (kompetisi_id && jenjang_id) {
                $('#tableTitle').html(`Klasemen Medali: <span class="text-primary">${teksKompetisi} - Tingkat ${teksJenjang}</span>`);
            } else {
                $('#tableTitle').text(`<?= $title; ?>`);
            }

            // Validasi di frontend sebelum tembak API
            if (!kompetisi_id || !jenjang_id) {
                $('#tableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center py-5 text-warning fw-medium">
                            <iconify-icon icon="ph:warning-circle" class="fs-1 d-block mb-2"></iconify-icon>
                            Pilih Kompetisi dan Jenjang Pendidikan terlebih dahulu untuk menampilkan data.
                        </td>
                    </tr>
                `);
                return; // Hentikan fungsi jika data tidak lengkap
            }

            $.ajax({
                url: `<?= site_url('api/jurnal-medali-kab'); ?>`,
                method: 'post',
                dataType: 'json',
                data: {
                    kompetisi_id: kompetisi_id,
                    jenjang_id: jenjang_id, // PERBAIKAN: Ubah jadi jenjang_id sesuai Controller
                    search: search
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2 text-muted">Memuat data klasemen...</div>
                            </td>
                        </tr>
                    `);
                },
                success: function(response) {
                    let html = ``;

                    if (response.length > 0) {
                        $.each(response, function(index, row) {
                            let podium = '';

                            if (row.ranking === 1) podium = '1st-place-medal';
                            else if (row.ranking === 2) podium = '2nd-place-medal';
                            else if (row.ranking === 3) podium = '3rd-place-medal';

                            html += `
                                <tr>
                                    <td class="text-center fw-bold">${row.ranking}</td>
                                    <td class="fw-medium">
                                        <div class="d-flex align-items-center gap-2">
                                            ${podium ? `<iconify-icon icon="fluent-emoji-flat:${podium}" width="24"></iconify-icon>` : `<span style="width: 24px;"></span>`}
                                            ${row.sekolah}
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-dark" style="background-color: #FDDE6C">${row.emas}</td>
                                    <td class="text-center fw-bold text-dark" style="background-color: #E3E4E5">${row.perak}</td>
                                    <td class="text-center fw-bold text-dark" style="background-color: #CD7F32">${row.perunggu}</td>
                                    <td class="text-center fw-bold bg-light">${row.total}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html += `
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <iconify-icon icon="ph:empty" class="fs-1 d-block mb-2"></iconify-icon>
                                    Data perolehan medali belum tersedia untuk filter ini.
                                </td>
                            </tr>
                        `;
                    }

                    $('#tableBody').html(html);
                },
                error: function(xhr) {
                    // Menangani pesan error 400 dari controller
                    let errorMsg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Terjadi kesalahan saat memuat data.';
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="6" class="text-center text-danger py-4">
                                <iconify-icon icon="bx:error-circle" class="fs-2 mb-2 d-block"></iconify-icon>
                                ${errorMsg}
                            </td>
                        </tr>
                    `);
                }
            });
        }

        // klik filter
        $('#btnFilter').on('click', function() {
            loadJurnalMedali();
        });

        // enter search
        $('#filterSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                loadJurnalMedali();
            }
        });

        // auto-load saat pilih jenjang atau kompetisi diganti (Optional tapi bagus untuk UX)
        $('#filterBentuk, #filterKompetisi').on('change', function() {
            loadJurnalMedali();
        });

        // reset filter
        $('#btnReset').on('click', function() {
            $('#filterKompetisi').val('1'); // Reset ke nilai default kompetisi jika ada
            $('#filterBentuk').val('1'); // Reset ke default jenjang
            $('#filterSearch').val('');
            loadJurnalMedali();
        });

        // load awal
        loadJurnalMedali();

        // Export Excel
        $('#btnExportExcel').on('click', function() {
            let kompid = $('#filterKompetisi').val();
            let jenid = $('#filterBentuk').val();

            if (!kompid || !jenid) {
                alert('Silakan pilih Kompetisi dan Jenjang terlebih dahulu sebelum melakukan export.');
                return;
            }

            // PERBAIKAN: Ubah bentuk_pendidikan menjadi jenjang_id
            let url = `<?= site_url('export/jurnal-medali-excel'); ?>` +
                `?kompetisi_id=${kompid}` +
                `&jenjang_id=${jenid}` +
                `&search=${$('#filterSearch').val()}`;

            window.open(url, '_blank');
        });

        // Export PDF
        $('#btnExportPdf').on('click', function() {
            let kompid = $('#filterKompetisi').val();
            let jenid = $('#filterBentuk').val();

            if (!kompid || !jenid) {
                alert('Silakan pilih Kompetisi dan Jenjang terlebih dahulu sebelum melakukan export.');
                return;
            }

            let url = `<?= site_url('export/jurnal-medali-pdf'); ?>` +
                `?kompetisi_id=${encodeURIComponent(kompid)}` +
                `&jenjang_id=${encodeURIComponent(jenid)}` +
                `&search=${encodeURIComponent($('#filterSearch').val())}`;

            window.open(url, '_blank');
        });
    })
</script>

<?= $this->endSection(); ?>