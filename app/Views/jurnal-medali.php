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
        <li class="fw-medium">SIMPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= $title; ?></h5>
            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Kompetisi</label>
                            <select id="filterKompetisi" class="form-select">
                                <option value="">Pilih Kompetisi</option>
                                <!-- loop dari backend -->
                                <?php foreach ($kompetisi as $k): ?>
                                    <option value="<?= $k['id']; ?>"><?= $k['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Bentuk Pendidikan</label>
                            <select id="filterBentuk" class="form-select">
                                <option value="">Semua Jenjang</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Cari Sekolah</label>
                            <input type="text" id="filterSearch" class="form-control" placeholder="Nama sekolah...">
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button id="btnFilter" class="btn btn-primary input-group w-100">
                                <span class="input-group align-items-center justify-content-center"><iconify-icon icon="line-md:filter"></iconify-icon> Filter
                                </span>
                            </button>
                            <button id="btnReset" class="btn btn-light">
                                Reset
                            </button>
                            <button id="btnExportExcel" class="btn btn-success input-group w-100">
                                <span class="input-group align-items-center justify-content-center">
                                    <iconify-icon icon="icon-park-solid:excel"></iconify-icon> Export
                                </span>
                            </button>
                        </div>
                    </div>

                    <table id="tableData" class="display table table-bordered table-hover table-striped dataTable mt-12" style="width:100%;">
                        <tr>
                            <td colspan="6" class="text-center">Pilih Tingkat Pendidikan dan Kompetisi</td>
                        </tr>
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
            let bentuk_pendidikan = $('#filterBentuk').val();
            let search = $('#filterSearch').val();

            $.ajax({
                url: `<?= site_url('api/jurnal-medali-kab'); ?>`,
                method: 'post',
                dataType: 'json',
                data: {
                    kompetisi_id: kompetisi_id,
                    bentuk_pendidikan: bentuk_pendidikan,
                    search: search // optional
                },
                beforeSend: function() {
                    $('#tableData').html(`
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="spinner-border text-primary"></div>
                    </td>
                </tr>
            `);
                },
                success: function(response) {

                    let html = `
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Sekolah</th>
                        <th class="text-center">Emas</th>
                        <th class="text-center">Perak</th>
                        <th class="text-center">Perunggu</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
            `;

                    if (response.length > 0) {
                        console.log(response);

                        $.each(response, function(index, row) {

                            let podium = '';

                            if (row.ranking === 1) podium = '1st-place-medal';
                            else if (row.ranking === 2) podium = '2nd-place-medal';
                            else if (row.ranking === 3) podium = '3rd-place-medal';

                            html += `
                        <tr>
                            <td>${row.ranking}</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    ${podium ? `<iconify-icon icon="fluent-emoji-flat:${podium}" width="22"></iconify-icon>` : ``}
                                    ${row.sekolah}
                                </span>
                            </td>
                            <td class="text-center" style="background-color: #FDDE6C ">${row.emas}</td>
                            <td class="text-center" style="background-color: #C0C0C0 ">${row.perak}</td>
                            <td class="text-center" style="background-color: #CD7F32">${row.perunggu}</td>
                            <td class="text-center fw-bold">${row.total}</td>
                        </tr>
                    `;
                        });
                    } else {
                        html += `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Data tidak tersedia
                        </td>
                    </tr>
                `;
                    }

                    html += `</tbody>`;
                    $('#tableData').html(html);
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

        // reset filter
        $('#btnReset').on('click', function() {
            $('#filterKompetisi').val('');
            $('#filterBentuk').val('');
            $('#filterSearch').val('');
            loadJurnalMedali();
        });

        // load awal
        $(document).ready(function() {
            loadJurnalMedali();
        });

        $('#btnExportExcel').on('click', function() {

            let url = `<?= site_url('export/jurnal-medali-excel'); ?>` +
                `?kompetisi_id=${$('#filterKompetisi').val()}` +
                `&bentuk_pendidikan=${$('#filterBentuk').val()}` +
                `&search=${$('#filterSearch').val()}`;

            window.open(url, '_blank');
        });


    })
</script>

<?= $this->endSection(); ?>