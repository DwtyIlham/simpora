<?php

/**
 * Partial: Tabel Prestasi Peserta (Shared)
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $title        -> Judul halaman
 *   $id_kompetisi -> ID kompetisi (encode_id akan dipakai)
 *   $peserta      -> Array data peserta
 *   $cabor        -> Array data cabor
 *   $sekolah      -> Array data sekolah
 *   $role         -> 'admin' | 'validator' | 'sekolah'
 *   $canAdd       -> boolean (tampilkan tombol Tambah)
 *   $canEdit      -> boolean (tampilkan tombol Edit)
 *   $canDelete    -> boolean (tampilkan tombol Hapus)
 *   $canBatch     -> boolean (tampilkan Unduh Piagam Batch, hanya admin)
 *   $addUrl       -> URL tambah prestasi
 *   $editUrl      -> URL edit prestasi (POST)
 *   $deleteUrl    -> URL hapus prestasi (GET prefix, akan ditambahkan ID)
 *   $batchUrl     -> URL unduh piagam batch (GET prefix)
 */

use function App\Controllers\encode_id;
use function App\Controllers\format_tgl;

$role    = $role ?? 'admin';
$canAdd  = $canAdd ?? ($role === 'admin');
$canEdit = $canEdit ?? ($role === 'admin');
$canDelete = $canDelete ?? ($role === 'admin');
$canBatch  = $canBatch ?? ($role === 'admin');
$canViewPeserta = $canViewPeserta ?? false;

$addUrl     = $addUrl ?? base_url('admin/kompetisi/prestasi-add/' . encode_id($id_kompetisi ?? ''));
$editUrl    = $editUrl ?? site_url('admin/kompetisi/prestasi-edit');
$deleteUrl  = $deleteUrl ?? base_url('prestasi/delete/');
$batchUrl   = $batchUrl ?? base_url('admin/piagam-batch/');

?>
<style>
    .prestasi-peserta-table td {
        vertical-align: middle;
    }

    .prestasi-peserta-action {
        gap: 6px;
        flex-wrap: nowrap;
    }

    .prestasi-peserta-table tbody tr:hover {
        background-color: rgba(37, 99, 235, .035);
    }

    .prestasi-summary {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: #64748b;
        font-size: .875rem;
        white-space: nowrap;
    }

    .prestasi-summary strong {
        color: #0f172a;
        font-size: 1rem;
    }

    .prestasi-peserta-header {
        padding: 0 0 1rem;
        border-bottom: 1px solid #e8edf5;
    }

    .prestasi-peserta-header>div:first-child {
        min-width: 0;
    }

    .prestasi-peserta-header>div:first-child>div {
        min-width: 0;
    }

    .prestasi-page-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 700;
        line-height: 1.35;
        color: #0f172a;
    }

    .prestasi-page-subtitle {
        margin: .2rem 0 0;
        color: #64748b;
        font-size: .825rem;
    }

    .prestasi-medal {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .3rem .65rem;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .prestasi-medal-1 {
        color: #946200;
        background: #fff4cf;
    }

    .prestasi-medal-2 {
        color: #475569;
        background: #edf2f7;
    }

    .prestasi-medal-3 {
        color: #8a4b26;
        background: #ffeadb;
    }

    .batch-card {
        border: 1px solid #e8edf5;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .035);
    }

    .batch-card .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.35rem;
    }

    .batch-card .card-header {
        background: transparent;
        border-bottom: 0;
        padding-bottom: 0;
    }

    .batch-card .card-body {
        padding-top: 1rem;
    }

    .prestasi-peserta-card {
        border: 1px solid #e8edf5;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, .035);
        overflow: hidden;
    }

    .prestasi-peserta-card>.card-header {
        padding: 1rem 1.25rem;
        background: #fff;
        border-bottom: 1px solid #edf1f6;
    }

    .prestasi-peserta-card>.card-body {
        padding: 1.25rem;
    }

    .prestasi-peserta-card .dataTable {
        margin-top: .25rem !important;
    }

    .prestasi-peserta-card .table> :not(caption)>*>* {
        padding: .8rem .75rem;
    }

    .batch-card .form-select,
    .batch-card .select2-container--bootstrap-5 .select2-selection {
        min-height: 42px;
        border-radius: 9px;
    }

    .batch-card .btn {
        min-height: 42px;
        border-radius: 9px;
        font-size: .925rem;
    }

    .prestasi-peserta-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }

    .prestasi-peserta-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(15, 23, 42, .12);
    }

    @media (max-width: 767.98px) {
        .prestasi-peserta-header {
            align-items: flex-start !important;
        }

        .prestasi-peserta-header>div:last-child {
            width: 100%;
        }

        .prestasi-peserta-header>div:last-child .btn {
            width: 100%;
            justify-content: center;
        }

        .prestasi-peserta-header>div:last-child .btn {
            width: 100%;
            justify-content: center;
        }

        .prestasi-peserta-card>.card-header {
            padding: .9rem 1rem;
        }

        .prestasi-peserta-card>.card-body {
            padding: .75rem;
        }

        .batch-card .card-header,
        .batch-card .card-body {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .prestasi-peserta-table {
            min-width: 700px;
        }
    }
</style>

<div class="prestasi-peserta-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20">
    <div class="d-flex align-items-center gap-3 flex-grow-1">
        <div>
            <h1 class="prestasi-page-title"><?= esc($title ?? 'Data Prestasi Peserta'); ?></h1>
            <p class="prestasi-page-subtitle">Daftar atlet berprestasi pada kompetisi ini</p>
        </div>
    </div>
    <?php if ($canAdd): ?>
        <div>
            <a href="<?= esc($addUrl); ?>" class="btn btn-primary-600 radius-8"><i class="ri-add-box-line me-1"></i> Tambah Atlet Prestasi</a>
        </div>
    <?php endif; ?>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12 prestasi-peserta-card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h2 class="card-title mb-1 fs-6 fw-semibold">Data Atlet Berprestasi</h2>
                    <small class="text-muted">Cari dan kelola data atlet serta piagamnya.</small>
                </div>
                <div class="prestasi-summary"><strong><?= count($peserta ?? []); ?></strong><span>atlet</span></div>
            </div>

            <?php if ($canBatch): ?>
                <!-- Unduh Piagam Batch -->
                <div class="card batch-card mb-12">
                    <div class="card-header">
                        <h6 class="mb-1 d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:file-download-outline" class="text-primary-600"></iconify-icon>
                            Unduh Piagam Batch
                        </h6>
                        <small class="text-muted">
                            Pilih cabang olahraga dan nomor cabang olahraga untuk mengunduh piagam sekaligus.
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    Cabang Olahraga <span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="filter_cabor_piagam" name="filter_cabor_piagam">
                                    <option value="">Pilih Cabang Olahraga</option>
                                    <?php foreach ($cabor ?? [] as $c): ?>
                                        <option value="<?= esc($c['id']); ?>"><?= esc($c['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    Nomor Cabang Olahraga <span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2" id="filter_nomor_cabor" name="filter_nomor_cabor" disabled>
                                    <option value="">Pilih cabang olahraga terlebih dahulu</option>
                                </select>
                            </div>
                            <div class="col-lg-4 d-grid align-middle">
                                <button type="button" class="btn btn-primary btn-lg" id="btnUnduhBatch" disabled>
                                    <iconify-icon icon="mdi:download-outline" class="me-1"></iconify-icon> Unduh Piagam Batch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card-body table-responsive data-table-shell">
                <table id="dataTable" class="display table table-bordered table-hover table-striped prestasi-peserta-table table-data table-data-wide" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center col-no">No.</th>
                            <th style="width:15%" class="text-start col-nama">Nama</th>
                            <th style="width:35%" class="text-start col-sekolah">Sekolah</th>
                            <th style="width:10%" class="text-center col-cabor">Cabor</th>
                            <th style="width:10%" class="text-center col-medali">Medali</th>
                            <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                <th style="width:15%" class="text-center col-aksi">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($peserta ?? [] as $p): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><span class="fw-semibold text-dark"><?= esc($p['atlet_nama'] ?? '-'); ?></span></td>
                                <td class="align-middle" style="text-align: left;"><?= esc($p['sekolah_nama'] ?? '-'); ?></td>
                                <td class="text-center align-middle"><span><?= esc($p['cabor_nama'] ?? '-'); ?></span><?= !empty($p['nomor_cabor_nama']) ? '<br /><small class="text-muted">' . esc($p['nomor_cabor_nama']) . '</small>' : ''; ?></td>
                                <?php $medal = (string) ($p['prestasi'] ?? ''); ?>
                                <td class="text-center align-middle"><span class="prestasi-medal prestasi-medal-<?= in_array($medal, ['1', '2', '3'], true) ? esc($medal) : '3'; ?>"><?= esc($medal === '1' ? 'Emas' : ($medal === '2' ? 'Perak' : ($medal === '3' ? 'Perunggu' : '-'))); ?></span></td>
                                <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                    <td class="text-center align-middle">
                                        <div class="prestasi-peserta-action">
                                            <a href="<?= site_url('pdf/view-piagam/') . encode_id($p['id'] ?? ''); ?>" target="_blank" rel="noopener"
                                                class="prestasi-peserta-btn btn-view-piagam bg-info-focus text-info-main rounded-circle"
                                                aria-label="Lihat piagam <?= esc($p['atlet_nama'] ?? 'atlet'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Piagam">
                                                <iconify-icon icon="carbon:certificate"></iconify-icon>
                                            </a>
                                            <?php if ($canEdit): ?>
                                                <a href="javascript:void(0)"
                                                    class="prestasi-peserta-btn btn-edit bg-success-focus text-success-main rounded-circle"
                                                    data-peserta="<?= esc($p['id']); ?>" data-bs-toggle="modal" data-bs-target="#editPrestasiModal">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($canDelete): ?>
                                                <a id="<?= esc($p['id']); ?>" data-kompetisi-id="<?= esc($p['kompetisi_id'] ?? ''); ?>"
                                                    class="prestasi-peserta-btn btn-delete bg-danger-focus text-danger-main rounded-circle">
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

<!-- Modal Edit Data Prestasi -->
<?php if ($canEdit): ?>
    <div class="modal fade" id="editPrestasiModal" tabindex="-1" aria-labelledby="editPrestasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPrestasiModalLabel">UBAH DATA PRESTASI PESERTA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form id="editPrestasiAttempt" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="kompetisi_id" value="<?= esc($id_kompetisi ?? ''); ?>">
                    <input type="hidden" name="peserta_id" id="peserta_id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="editNama">Nama</label>
                                <input type="text" class="form-control" id="editNama" readonly>
                                <label for="editSekolah">Sekolah</label>
                                <input type="text" class="form-control" id="editSekolah" readonly>
                                <label for="editCabor">Cabor</label>
                                <input type="text" class="form-control" id="editCabor" readonly>
                                <label for="editMedali">Medali</label>
                                <select class="form-select" id="editPrestasi" name="prestasi">
                                    <option value="" disabled>Pilih Medali</option>
                                    <option value="1">Emas</option>
                                    <option value="2">Perak</option>
                                    <option value="3">Perunggu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal Piagam / Belum Terpakai -->
<div class="modal fade" id="piagamModal" tabindex="-1" aria-labelledby="piagamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="piagamModalLabel">PIAGAM ATLET BERPRESTASI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-1">
                <div class="card mt-12 bg-light">
                    <h5 class="card-title mb-0" id="card-title"></h5>
                    <div class="card-body m-auto p-1">
                        <div class="piagam" style="text-align: center;">
                            <div class="piagam-container">
                                <img src="<?= base_url('public/assets/images/piagam_popda.png') ?>" class="piagam-bg">

                                <!-- Nomor piagam -->
                                <div class="field nomor">xxx.xxx.123.2025</div>

                                <!-- Nama -->
                                <div class="field nama" id="piagam-nama">Nama Atlet</div>

                                <!-- Sekolah -->
                                <div class="field sekolah" id="piagam-sekolah">Nama Sekolah</div>

                                <!-- Sebagai -->
                                <div class="field sebagai" id="piagam-sebagai">Juara 1 Cabor ...</div>

                                <!-- Tanggal -->
                                <div class="field tanggal">Banjarnegara, 12 Februari 2025</div>

                                <!-- Nama Kepala Dinas -->
                                <div class="field kadis">Nama Kepala Dinas</div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .piagam-container {
                            width: 1000px;
                            position: relative;
                            margin: auto;
                        }

                        .piagam-bg {
                            width: 100%;
                            display: block;
                        }

                        .field {
                            position: absolute;
                            font-family: 'Times New Roman', serif;
                            color: #000;
                        }

                        .nomor {
                            top: 240px;
                            left: 420px;
                            font-size: 22px;
                        }

                        .nama {
                            top: 360px;
                            left: 330px;
                            font-size: 28px;
                            font-weight: bold;
                        }

                        .sekolah {
                            top: 420px;
                            left: 330px;
                            font-size: 24px;
                        }

                        .sebagai {
                            top: 480px;
                            left: 330px;
                            font-size: 24px;
                        }

                        .tanggal {
                            top: 650px;
                            left: 560px;
                            font-size: 20px;
                        }

                        .kadis {
                            top: 780px;
                            left: 560px;
                            font-size: 22px;
                            font-weight: bold;
                        }
                    </style>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" onclick="downloadpiagam()">Download</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    $(function() {
        const canBatch = <?= json_encode($canBatch); ?>;
        const canEdit = <?= json_encode($canEdit); ?>;
        const deleteUrl = '<?= esc($deleteUrl); ?>';
        const editUrl = '<?= esc($editUrl); ?>';

        // Batch piagam (hanya admin)
        if (canBatch) {
            $('#filter_cabor_piagam').select2({
                theme: 'bootstrap-5',
                width: '100%',
                closeOnSelect: true,
                placeholder: 'Pilih Cabang Olahraga',
                allowClear: true
            });
            $('#filter_nomor_cabor').select2({
                theme: 'bootstrap-5',
                width: '100%',
                closeOnSelect: true,
                placeholder: 'Pilih Nomor Cabang Olahraga',
                allowClear: true
            });
            $('#filter_cabor_piagam').on('change', function() {
                const id = $(this).val();
                const $nomorCabor = $('#filter_nomor_cabor');
                $('#btnUnduhBatch').prop('disabled', true);
                $nomorCabor.prop('disabled', true).html('<option value="">Memuat nomor cabor...</option>').trigger('change.select2');
                if (id === '') {
                    $nomorCabor.html('<option value="">Pilih cabang olahraga terlebih dahulu</option>').trigger('change.select2');
                    return;
                }
                $.ajax({
                    url: '<?= site_url('api/getNomorCaborPiagam') ?>',
                    type: 'POST',
                    data: {
                        cabor_id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let html = '<option value="">Pilih Nomor Cabor</option>';
                        if (response) {
                            $.each(response, function(i, item) {
                                html += `<option value="${item.id}">${escHtml(item.nama)}</option>`;
                            });
                        }
                        $nomorCabor.html(html).prop('disabled', false).val('').trigger('change.select2');
                    },
                    error: function() {
                        $nomorCabor.html('<option value="">Gagal memuat. Coba pilih cabor lagi.</option>').trigger('change.select2');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal memuat',
                            text: 'Tidak dapat mengambil data nomor cabor.'
                        });
                    }
                });
            });

            $('#filter_nomor_cabor').on('change', function() {
                $('#btnUnduhBatch').prop('disabled', !$(this).val());
            });

            $('#btnUnduhBatch').on('click', function() {
                const nomorCaborId = $('#filter_nomor_cabor').val();
                if (!nomorCaborId) return;
                window.open('<?= esc($batchUrl); ?>' + encodeURIComponent(nomorCaborId), '_blank', 'noopener');
            });
        }

        // Hapus prestasi
        $(document).on('click', '.btn-delete', function() {
            const atletID = $(this).attr('id');
            const kompetisiId = $(this).data('kompetisi-id');

            Swal.fire({
                title: 'Yakin Hapus Data Prestasi Peserta?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#93999f',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl + atletID + '/' + kompetisiId;
                }
            });
        });

        // Edit prestasi
        $(document).on('click', '.btn-edit', function() {
            const pesertaID = $(this).data('peserta');
            const nama = $(this).closest('tr').find('td:eq(1)').text().trim();
            const sekolah = $(this).closest('tr').find('td:eq(2)').text().trim();
            const cabor = $(this).closest('tr').find('td:eq(3)').text().trim();
            const prestasi = $(this).closest('tr').find('td:eq(4)').text().trim();
            const selPrestasi = prestasi === 'Emas' ? '1' : (prestasi === 'Perak' ? '2' : '3');

            $('#editNama').val(nama);
            $('#peserta_id').val(pesertaID);
            $('#editSekolah').val(sekolah);
            $('#editCabor').val(cabor);
            $('#editPrestasi').val(selPrestasi);
            $('#editPrestasiAttempt').attr('action', editUrl);
        });

        // Render piagam raster hanya saat fitur preview digunakan.
        function downloadpiagam() {
            if (typeof html2canvas === 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak dapat mengunduh',
                    text: 'Komponen piagam tidak tersedia.'
                });
                return;
            }
            const container = document.querySelector('.piagam-container');
            html2canvas(container, {
                scale: 1,
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(function(canvas) {
                const link = document.createElement('a');
                link.download = 'piagam.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal membuat piagam',
                    text: 'Silakan coba kembali.'
                });
            });
        }
        window.downloadpiagam = downloadpiagam;

        function escHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    });
</script>