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
    .prestasi-peserta-table td { vertical-align: middle; }
    .prestasi-peserta-action { gap: 4px; flex-wrap: nowrap; }
    .prestasi-peserta-btn {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        transition: transform .15s ease, box-shadow .15s ease;
        text-decoration: none;
    }
    .prestasi-peserta-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .12); }
    .batch-card .form-label { font-size: 0.875rem; font-weight: 600; margin-bottom: 0.35rem; }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Data Prestasi Peserta'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="<?= base_url($role === 'admin' ? 'admin/kompetisi/data' : ($role === 'validator' ? 'validator/kompetisi/data' : 'sekolah/kompetisi/data')); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Data Prestasi Peserta'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <?php if ($canAdd): ?>
        <div>
            <a href="<?= esc($addUrl); ?>" class="btn btn-primary-600 radius-8"><i class="ri-add-box-line"></i> Tambah Atlet Prestasi</a>
        </div>
    <?php endif; ?>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <button onclick="history.back()" class="btn bg-danger-focus text-danger-main radius-8 px-20 py-11 d-flex align-items-center justify-content-center gap-2">
                    <iconify-icon icon="mingcute:square-arrow-left-line" class="text-xl"></iconify-icon> Kembali
                </button>
                <h5 class="card-title mb-0"><?= esc($title ?? 'Data Prestasi Peserta'); ?></h5>
            </div>

            <?php if ($canBatch): ?>
                <!-- Unduh Piagam Batch -->
                <div class="card batch-card mb-12">
                    <div class="card-header">
                        <h6 class="mb-1">
                            <iconify-icon icon="mdi:file-download-outline"></iconify-icon>
                            Unduh Piagam Batch
                        </h6>
                        <small class="text-muted">
                            Pilih cabang olahraga dan nomor cabang olahraga, kemudian klik tombol untuk mengunduh seluruh piagam.
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
                                <select class="form-select select2" id="filter_nomor_cabor" name="filter_nomor_cabor">
                                    <option value="">Pilih Nomor Cabang Olahraga</option>
                                </select>
                            </div>
                            <div class="col-lg-4 d-grid align-middle">
                                <button type="button" class="btn btn-primary btn-lg" id="btnUnduhBatch">
                                    Unduh Piagam Batch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card-body table-responsive">
                <table id="dataTable" class="display table table-bordered table-hover table-striped prestasi-peserta-table" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:15%" class="text-start">Nama</th>
                            <th style="width:35%" class="text-start">Sekolah</th>
                            <th style="width:10%" class="text-center">Cabor</th>
                            <th style="width:10%" class="text-center">Medali</th>
                            <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                <th style="width:15%" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($peserta ?? [] as $p): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><?= esc($p['atlet_nama'] ?? '-'); ?></td>
                                <td class="align-middle" style="text-align: left;"><?= esc($p['sekolah_nama'] ?? '-'); ?></td>
                                <td class="text-center align-middle"><?= esc($p['cabor_nama'] ?? '-'); ?><?= !empty($p['nomor_cabor_nama']) ? '<br /><small>' . esc($p['nomor_cabor_nama']) . '</small>' : ''; ?></td>
                                <td class="text-center align-middle"><?= esc($p['prestasi'] === '1' ? 'Emas' : ($p['prestasi'] === '2' ? 'Perak' : 'Perunggu')); ?></td>
                                <?php if ($canViewPeserta || $canEdit || $canDelete): ?>
                                    <td class="text-center align-middle">
                                        <div class="prestasi-peserta-action">
                                            <a href="<?= site_url('pdf/view-piagam/') . encode_id($p['id'] ?? ''); ?>" target="_blank"
                                                class="prestasi-peserta-btn btn-view-piagam bg-info-focus text-info-main rounded-circle"
                                                data-id="<?= esc($p['id']); ?>" data-atlet-id="<?= esc($p['atlet_id'] ?? $p['id']); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Piagam">
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
                        .piagam-bg { width: 100%; display: block; }
                        .field {
                            position: absolute;
                            font-family: 'Times New Roman', serif;
                            color: #000;
                        }
                        .nomor { top: 240px; left: 420px; font-size: 22px; }
                        .nama { top: 360px; left: 330px; font-size: 28px; font-weight: bold; }
                        .sekolah { top: 420px; left: 330px; font-size: 24px; }
                        .sebagai { top: 480px; left: 330px; font-size: 24px; }
                        .tanggal { top: 650px; left: 560px; font-size: 20px; }
                        .kadis { top: 780px; left: 560px; font-size: 22px; font-weight: bold; }
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
        const canEdit  = <?= json_encode($canEdit); ?>;
        const deleteUrl = '<?= esc($deleteUrl); ?>';
        const editUrl = '<?= esc($editUrl); ?>';

        // Batch piagam (hanya admin)
        if (canBatch) {
            $('#filter_cabor_piagam').on('change', function() {
                const id = $(this).val();
                $('#filter_nomor_cabor').html('<option value="">Memuat...</option>');
                if (id === '') {
                    $('#filter_nomor_cabor').html('<option value="">Pilih Nomor Cabor</option>');
                    return;
                }
                $.ajax({
                    url: '<?= site_url('api/getNomorCaborPiagam') ?>',
                    type: 'POST',
                    data: { cabor_id: id },
                    dataType: 'json',
                    success: function(response) {
                        let html = '<option value="">Pilih Nomor Cabor</option>';
                        if (response) {
                            $.each(response, function(i, item) {
                                html += `<option value="${item.id}">${escHtml(item.nama)}</option>`;
                            });
                        }
                        $('#filter_nomor_cabor').html(html).trigger('change');
                    },
                    error: function() {
                        alert('Gagal mengambil data nomor cabor.');
                    }
                });
            });

            $('#btnUnduhBatch').on('click', function() {
                const nomor_cabor_id = $('#filter_nomor_cabor').val();
                if (!nomor_cabor_id) {
                    alert('Silakan pilih Nomor Cabor terlebih dahulu.');
                    return;
                }
                window.open('<?= esc($batchUrl); ?>' + nomor_cabor_id, '_blank');
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

        // View piagam (QR)
        $(document).on('click', '.btn-view-piagam', function() {
            const id = $(this).data('atlet-id') || $(this).data('id');
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= site_url('api/validasi/qr-code-atlet/'); ?>${id}`;

            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.src = qrUrl;
            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                $('#piagam-qrcode').attr('src', canvas.toDataURL('image/png'));
            };
        });

        function downloadpiagam() {
            html2canvas(document.querySelector('.piagam-container')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'piagam.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }

        function escHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    });
</script>
