<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\encode_id;
use function App\Controllers\format_tgl;
use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= site_url('admin/kompetisi/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
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
                <button onclick="history.back()" class="btn bg-danger-focus text-danger-main radius-8 px-20 py-11 d-flex align-items-center justify-content-center gap-2" data-bs-dismiss="modal">
                    <iconify-icon icon="mingcute:square-arrow-left-line" class="text-xl"></iconify-icon> Kembali
                </button>
                <h5 class="card-title mb-0"><?= $title; ?></h5>
                <?php if (isAdmin()) : ?>
                    <a href="<?= base_url('admin/kompetisi/prestasi-add/' . encode_id($id_kompetisi)); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Atlet Prestasi</a>
                <?php endif; ?>
            </div>
            <div class="card-body gy-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Filter Cabor</label>
                        <span class="icon align-middle">
                            <iconify-icon icon="fluent:sport-24-regular" width="24" height="24"></iconify-icon>
                        </span>
                        <div class="icon-field">
                            <select class="form-select select2" name="filter_cabor" id="filter_cabor" data-placeholder="Pilih Cabang Olahraga">
                                <option value=""></option>
                                <?php foreach ($cabor as $c): ?>
                                    <option value="<?= $c['id']; ?>" data-nama="<?= $c['nama']; ?>"><?= $c['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Filter Sekolah</label>
                        <span class="icon align-middle">
                            <iconify-icon icon="icon-park-outline:school" width="20" height="20"></iconify-icon>
                        </span>
                        <div class="icon-field">
                            <select class="form-select select2" name="filter_sekolah" id="filter_sekolah" data-placeholder="Pilih Sekolah">
                                <option value=""></option>
                                <?php foreach ($sekolah as $s): ?>
                                    <option value="<?= $s['id']; ?>" data-nama="<?= $s['nama']; ?>"><?= $s['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="display table table-bordered table-hover table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:15%" class="text-start">Nama</th>
                            <th style="width:35%" class="text-start">Sekolah</th>
                            <th style="width:10%" class="text-center">Cabor</th>
                            <th style="width:10%" class="text-center">Medali</th>
                            <th style="width:15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($peserta as $p): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><?= $p['atlet_nama']; ?></td>
                                <td class="align-middle" style="text-align: left;"><?= $p['sekolah_nama']; ?></td>
                                <td class="text-center align-middle"><?= $p['cabor_nama']; ?></td>
                                <td class="text-center align-middle"><?= $p['prestasi'] === '1' ? 'Emas' : ($p['prestasi'] === '2' ? 'Perak' : 'Perunggu'); ?></td>
                                <td class="text-center align-middle m-auto">
                                    <!-- .btn-view-piagam utk buka modal -->
                                    <a href="<?= site_url('pdf/view-piagam/') . encode_id($p['id']); ?>" data-id="<?= $p['id']; ?>" target="_blank"
                                        class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Piagam">
                                        <iconify-icon icon="carbon:certificate"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn-edit w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-peserta="<?= $p['id']; ?>" data-bs-toggle="modal" data-bs-target="#editPrestasiModal">
                                        <iconify-icon icon="lucide:edit"><?= $p['id']; ?></iconify-icon>
                                    </a>
                                    <a id="<?= $p['id']; ?>" data-kompetisi-id="<?= $p['kompetisi_id']; ?>" class="btn-delete w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
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

<!-- Modal Edit Data Prestasi -->
<div class="modal fade" id="editPrestasiModal" tabindex="-1" aria-labelledby="editPrestasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPrestasiModalLabel">UBAH DATA PRESTASI PESERTA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="editPrestasiAttempt" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="kompetisi_id" value="<?= $id_kompetisi; ?>">
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
                            <select class="form-select" name="prestasi_id" id="editPrestasi" name="prestasi">
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
                </div>

                <style>
                    .piagam-container {
                        width: 1000px;
                        /* sesuaikan ukuran real PNG */
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

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    // delete kompetisi
    $(document).on('click', '.btn-delete', function() {
        let atletID = $(this).attr('id');
        let kompetisiId = $(this).data('kompetisi-id');

        Swal.fire({
            title: "Yakin Hapus Data Kompetisi Tersebut?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#93999f',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/kompetisi/peserta/delete/'); ?>" + atletID + '/' + kompetisiId;
            }
        });
    });

    $(document).on('click', '.btn-view-piagam', function() {
        let modal = $('#piagamModal');
        let id = $(this).data('id');
        let folder_foto_atlet = `<?= base_url('uploads/atlet/file_foto/') ?>`;
        let validasi_url = `<?= site_url('api/validasi/qr-code-atlet/'); ?>` + id;

        let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${validasi_url}`;

        let img = new Image();
        img.crossOrigin = "anonymous"; // wajib
        img.src = qrUrl;

        img.onload = function() {
            // buat canvas
            let canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;

            let ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

            // ambil base64
            let base64 = canvas.toDataURL("image/png");

            // tampilkan ke piagam
            $("#piagam-qrcode").attr("src", base64);
        };

        img.onerror = function() {
            console.log("QR gagal diambil via CORS, gunakan generator lokal");
        };


        // $.ajax({
        //     url: `<?= site_url('api/getDataPesertaPiagam'); ?>`,
        //     method: 'post',
        //     data: {
        //         id: id
        //     },
        //     success: function(res) {
        //         $('#piagamModalLabel').text('ID Card Peserta - ' + res['atlet_nama']);
        //         $('#piagam-title').html(`<span>${res['kompetisi_nama']}</span><br/><small class="text-label">${res['deskripsi']}</small>`);
        //         $('#piagam-foto').attr('src', folder_foto_atlet + res['file_foto']);
        //         $('#piagam-atlet').text(res['atlet_nama']);
        //         $('#piagam-sekolah').text(res['sekolah_nama']);
        //         $('#piagam-cabor').text(res['cabor_nama'].toUpperCase());
        //         modal.modal('show');
        //     }
        // });
    });

    function downloadpiagam() {
        html2canvas(document.querySelector(".piagam-container")).then(canvas => {
            const link = document.createElement("a");
            link.download = "piagam.png";
            link.href = canvas.toDataURL();
            link.click();
        });
    }

    // script edit data prestasi
    $(document).on('click', '.btn-edit', function() {
        let pesertaID = $(this).data('peserta');
        let nama = $(this).closest('tr').find('td:eq(1)').text().trim();
        let sekolah = $(this).closest('tr').find('td:eq(2)').text().trim();
        let cabor = $(this).closest('tr').find('td:eq(3)').text().trim();
        let prestasi = $(this).closest('tr').find('td:eq(4)').text().trim();
        let selPrestasi = prestasi == 'Emas' ? '1' : (prestasi == 'Perak' ? '2' : '3');

        $('#editNama').val(nama);
        $('#peserta_id').val(pesertaID);
        $('#editSekolah').val(sekolah);
        $('#editCabor').val(cabor);
        $('#editPrestasi').val(selPrestasi);

        $('#editPrestasiAttempt').attr('action', '<?= site_url('admin/kompetisi/prestasi-edit'); ?>');
    })
</script>

<?= $this->endSection(); ?>