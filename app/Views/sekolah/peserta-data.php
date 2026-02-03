<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\format_tgl;
use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    .modal-body h6 {
        font-weight: 600;
    }

    .form-control[readonly] {
        cursor: not-allowed;
    }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-12">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= site_url('sekolah/kompetisi/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
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
            <div class="card-header">
                <a href="<?= base_url('sekolah/kompetisi/data'); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Kompetisi</a>
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?= $title; ?></h5>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('sekolah/kompetisi/peserta/add/' . $id_kompetisi); ?>"
                        class="btn btn-primary-600">
                        <i class="ri-add-box-line"></i> Tambah Peserta
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="dataTable" class="display table table-bordered table-hover table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-start">Nama</th>
                            <th class="text-start">Sekolah</th>
                            <th class="text-center">Cabor</th>
                            <th class="text-center">Nomor</th>
                            <th class="text-center">Aksi</th>
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
                                <td class="align-middle">
                                    <?php $nocab = explode('||', $p['nomor_cabor']) ?? '-'; ?>
                                    <?php foreach ($nocab as $i => $nc): ?>
                                        <?= $nc; ?><br />
                                    <?php endforeach; ?>
                                </td>
                                <td class="text-center align-middle m-auto">
                                    <a data-id="<?= $p['id']; ?>"
                                        class="btn-view-idcard w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat ID Card">
                                        <iconify-icon icon="lucide:id-card-lanyard"></iconify-icon>
                                    </a>
                                    <?php
                                    $disable = is_array($nocab) && count($nocab) > 1;
                                    if (!$disable): ?>
                                        <a href="#"
                                            class="btn-add-atlet-multi-cabor w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                            data-peserta-id="<?= $p['id']; ?>" data-cabor-id="<?= $p['cabor_id']; ?>"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="<?= $disable ? 'Atlet sudah memiliki lebih dari 1 nomor cabor' : 'Tambah Atlet Multi Cabor'; ?>">

                                            <iconify-icon icon="mdi:account-multiple-add"></iconify-icon>
                                        </a>
                                    <?php else: '';
                                    endif; ?>
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
                            <div class="header d-flex align-items-center justify-content-between text-center">
                                <img src="<?= base_url('public/assets/images/logo_bna.svg') ?>" class="logo img-fluid" />
                                <div class="event fw-bold align-middle" id="idcard-title"></div>
                                <img src="<?= base_url('public/assets/images/icon.png') ?>" id="logo-simpora" class="logo img-fluid" />
                            </div>
                            <!-- Foto -->
                            <div class="foto-wrap text-center mt-12">
                                <!-- Foto Atlet -->
                                <img src="" id="idcard-foto" class="foto shadow-sm" />
                            </div>

                            <div class="role mt-12">ATLET</div>

                            <!-- Nama -->
                            <div class="nama fw-bold text-center mt-2" id="idcard-atlet">
                                <!-- Nama Atlet -->
                            </div>

                            <!-- Sekolah -->
                            <div class="sekolah text-center small text-muted" id="idcard-sekolah">
                                <!-- Nama Sekolah -->
                            </div>

                            <!-- Cabor -->
                            <div class="cabor text-center small mb-1">
                                <span class="fw-semibold" id="idcard-cabor">
                                    <!-- Nama Cabor -->
                                </span>
                            </div>

                            <!-- QR Code -->
                            <div class="qrcode-wrap" style="position: relative; display: inline-block;">
                                <img src="<?= base_url('public/assets/images/dummy-qr.webp') ?>" id="idcard-qrcode" class="qrcode img-fluid p-4" />
                                <div id="idcard-qr-loader" class="qr-loader d-none">
                                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                                </div>
                            </div>

                            <!-- Footer Bar -->
                            <div class="footer"><span class="text-light"><small>SIMPORA - BANJARNEGARA</small></span></div>
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
                        position: relative;
                    }

                    /* Screen & export */
                    .idcard img.logo,
                    .idcard img.qrcode,
                    .idcard img.foto {
                        max-width: 100%;
                        height: auto;
                    }

                    /* Print only */
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
                        /* height: 10vh; */
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
                        width: 103px;
                        height: 103px;
                        /* right: 14px; */
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="downloadIdCard()">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Atlet Multi Cabor -->
<div class="modal fade" id="modal-add-atlet-multi-cabor" tabindex="-1" aria-labelledby="modal-add-atlet-multi-cabor-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formAddMultiCabor" action="<?= site_url('sekolah/addPesertaMultiCabor'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-atlet-multi-cabor-label">Tambah Atlet Multi Cabor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <input type="hidden" name="peserta_id" id="peserta_id">
                            <!-- CABOR TERDAFTAR -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-list-check"></i> Cabor Terdaftar
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small">Nama Cabor</label>
                                        <input type="text" class="form-control bg-light" id="md-cabor-1" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Nomor Cabor</label>
                                        <input type="text" class="form-control bg-light" id="md-nocabor-1" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- TAMBAH CABOR -->
                            <div>
                                <h6 class="my-3">
                                    <i class="bi bi-plus-circle-fill text-success"></i>
                                    Tambah Nomor Cabor
                                </h6>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Cabor</label>
                                        <select class="form-select select2" id="md-multi-cabor" data-placeholder="Pilih Cabor" disabled>
                                            <option></option>
                                            <?php foreach ($cabor as $c): ?>
                                                <option value="<?= $c['id']; ?>"><?= $c['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Nomor Cabor</label>
                                        <select id="nomor_cabor" name="nocabor_baru" class="form-select select2" data-placeholder="Pilih Nomor Cabor" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="alert alert-info bg-info-100 text-info-600 border-info-100 px-24 py-11 mb-0 radius-8 py-2 mt-3 d-flex align-items-center gap-2" role="alert">
                                    <iconify-icon icon="material-symbols:info" width="20" height="20"></iconify-icon>
                                    <span>
                                        Cabor baru akan <strong>ditambahkan</strong> dan tidak menghapus data sebelumnya.
                                    </span>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button role="submit" class="btn btn-primary-600"><i class="ri-save-line"></i> Simpan</button>
                </div>
            </form>
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
                window.location.href = "<?= base_url('sekolah/kompetisi/peserta/delete/'); ?>" + atletID + '/' + kompetisiId;
            }
        });
    });

    $(document).on('click', '.btn-view-idcard', function() {
        let modal = $('#qrModal');
        let id = $(this).data('id');
        let folder_foto_atlet = `<?= base_url('uploads/atlet/file_foto/') ?>`;
        let validasi_url = `<?= site_url('api/validasi/qr-code-atlet/'); ?>` + id;

        let qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${validasi_url}`;

        let img = new Image();
        img.crossOrigin = "anonymous"; // wajib
        img.src = qrUrl;

        // show qr loader (if present)
        if ($('#idcard-qr-loader').length) {
            $('#idcard-qr-loader').removeClass('d-none');
            $('#idcard-qrcode').attr('src', '<?= base_url('public/assets/images/dummy-qr.webp') ?>');
        }

        img.onload = function() {
            // buat canvas
            let canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;

            let ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

            // ambil base64
            let base64 = canvas.toDataURL("image/png");

            // tampilkan ke idcard
            $("#idcard-qrcode").attr("src", base64);

            // hide loader
            if ($('#idcard-qr-loader').length) {
                $('#idcard-qr-loader').addClass('d-none');
            }
        };

        img.onerror = function() {
            console.log("QR gagal diambil via CORS, gunakan generator lokal");
            if ($('#idcard-qr-loader').length) {
                $('#idcard-qr-loader').addClass('d-none');
            }
        };

        $.ajax({
            url: `<?= site_url('api/getDataPesertaIDCard'); ?>`,
            method: 'post',
            data: {
                id: id
            },
            success: function(res) {
                $('#qrModalLabel').text('ID Card Peserta - ' + res['atlet_nama']);
                $('#idcard-title').html(`<span>${res['kompetisi_nama']}</span><br /><small class="text-label">${res['deskripsi']}</small>`);
                $('#idcard-foto').attr('src', folder_foto_atlet + res['file_foto']);
                $('#idcard-atlet').text(res['atlet_nama']);
                $('#idcard-sekolah').text(res['sekolah_nama']);
                $('#idcard-cabor').text(res['cabor_nama'].toUpperCase());
                modal.modal('show');
            }
        });
    });

    function downloadIdCard() {
        const element = document.querySelector(".idcard");
        let nama_atlet = $('#idcard-atlet').text();

        // Freeze current size
        const rect = element.getBoundingClientRect();
        element.style.width = rect.width + 'px';
        element.style.height = rect.height + 'px';

        // Pastikan font sudah siap
        document.fonts.ready.then(() => {
            html2canvas(element, {
                scale: 3,
                // scale: window.devicePixelRatio * 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: "#ffffff",
                letterRendering: true,
                logging: false
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");

                const link = document.createElement("a");
                link.download = `ID Card - ${nama_atlet}.png`;
                link.href = imgData;
                link.click();
            });
        });
    }

    // modal atlet multi cabor
    $('.btn-add-atlet-multi-cabor').on('click', function() {
        let atlet = $(this).closest('tr').find('td').eq('1').text().trim();
        let peserta_id = $(this).data('peserta-id');
        let cabor_1 = $(this).closest('tr').find('td').eq('3').text().trim();
        let nocabor_1 = $(this).closest('tr').find('td').eq('4').text().trim();
        let cabor_id = $(this).data('cabor-id');

        $('#peserta_id').val(peserta_id);
        $('#modal-add-atlet-multi-cabor-label').text('Form Multi Cabor - ' + atlet);
        $('#md-cabor-1').val(cabor_1);
        $('#md-nocabor-1').val(nocabor_1);
        $('#md-multi-cabor').val(cabor_id).change();
        $('#modal-add-atlet-multi-cabor').modal('show');
    });

    // select2 modal
    $('#modal-add-atlet-multi-cabor').on('shown.bs.modal', function() {
        $('.select2').select2({
            dropdownParent: $('#modal-add-atlet-multi-cabor')
        });
    });

    // load nomor cabor berdasar cabor terpilih
    $('#md-multi-cabor').on('change', function() {
        let caborId = $(this).val();
        $.ajax({
            url: "<?= site_url('api/getNomorCabor'); ?>",
            method: 'POST',
            data: {
                cabor_id: caborId,
                <?= csrf_token() ?>: "<?= csrf_hash() ?>"
            },
            dataType: 'json',
            success: function(response) {
                let nomorCaborSelect = $('#nomor_cabor');
                nomorCaborSelect.attr('disabled', false);
                nomorCaborSelect.empty();
                nomorCaborSelect.append('<option></option>'); // Placeholder

                response.forEach(function(nomorCabor) {
                    nomorCaborSelect.append(
                        `<option value="${nomorCabor.id}">${nomorCabor.nama} ${nomorCabor.kategori} ${nomorCabor.jenjang}</option>`
                    );
                });
            },
            error: function() {
                alert('Gagal mengambil data nomor cabor.');
            }
        });
    });
</script>

<?= $this->endSection(); ?>