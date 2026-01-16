<?php

use CodeIgniter\Database\BaseUtils;

use function App\Controllers\isAdmin;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php $role = session('user')['role_id'] == '1' ? 'admin' : 'sekolah' ?>

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
        <li class="fw-medium">SIMPORA</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card basic-data-table mt-12">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Data Atlet Pelajar</h5>
                <a href="<?= base_url($role . '/atlet/add'); ?>" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Atlet</a>
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
                                    <option value="<?= $c['id']; ?>" data-nama="<?= $c['nama']; ?>"><?= $c['nama']; ?></option>
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
                                    <option value="<?= $s['id']; ?>" data-nama="<?= $s['nama']; ?>"><?= $s['nama']; ?></option>
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
                                <option value="valid" data-status="valid">Valid</option>
                                <option value="invalid" data-status="invalid">Invalid</option>
                                <option value="pending" data-status="pending">Pending</option>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $jenis_dok = ['kk_status', 'akte_status', 'foto_status', 'ktp_kia_status', 'nisn_status', 'ijazah_status'];
                        foreach ($atlet as $a):
                            $err_validasi_dokumen = 0;
                            foreach ($jenis_dok as $jd) {
                                if ($jd !== 'ijazah_status') {
                                    $a[$jd] === 'valid' ? $err_validasi_dokumen += 0 : $err_validasi_dokumen += 1;
                                }
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center">
                                    <?php if (isAdmin()): ?>
                                        <a href="javascript:void(0)" data-id="<?= $a['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail & Validasi" data-bs-title="Detail dan Validasi"
                                            class="view-atlet w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="hugeicons:validation-approval"></iconify-icon>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('sekolah/atlet/edit/') . $a['id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a id="<?= $a['id']; ?>" class="delete-atlet w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-status-depan <?= $err_validasi_dokumen > 0 ? 'bg-warning text-dark' : 'bg-success text-light' ?>" data-id="<?= $a['id']; ?>">
                                        <?= $err_validasi_dokumen > 0 ? 'Belum Valid' : 'Valid' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('public'); ?>/uploads/atlet/file_foto/<?= $a['file_foto']; ?>" alt="Image" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                        <span class="text-wrap text-md mb-0 fw-medium flex-grow-1"><?= $a['nama']; ?></span>
                                    </div>
                                </td>
                                <td><?= $a['sekolah']; ?></td>
                                <td class="text-center"><?= $a['jenis_kelamin']; ?></td>
                                <td><?= $a['cabor']; ?></td>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL ATLET -->
<div class="modal fade" id="viewAtletModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary-600 text-white">
                <h5 class="modal-title text-light">Detail & Verifikasi Atlet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    <!-- DATA ATLET -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary-light text-primary-600 text-white">
                                <h6 class="mb-0">Data Atlet</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="text-muted">Nama</label>
                                    <div class="fw-bold" id="v-nama">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">NISN</label>
                                    <div class="fw-bold" id="v-nisn">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">NIK</label>
                                    <div class="fw-bold" id="v-nik">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">Sekolah</label>
                                    <div class="fw-bold" id="v-sekolah">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">Cabor</label>
                                    <div class="fw-bold" id="v-cabor">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">Jenis Kelamin</label>
                                    <div class="fw-bold" id="v-jk">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">Tempat, Tanggal Lahir</label>
                                    <div class="fw-bold" id="v-ttl">-</div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-muted">Alamat</label>
                                    <div class="fw-bold" id="v-alamat">-</div>
                                </div>
                            </div>
                            <button class="btn bg-danger-focus text-danger-main radius-8 px-20 py-11 d-flex align-items-center justify-content-center gap-2" data-bs-dismiss="modal">
                                <iconify-icon icon="mingcute:square-arrow-left-line" class="text-xl"></iconify-icon> Kembali
                            </button>
                        </div>
                    </div>

                    <!-- FILE GALLERY -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary-light text-white">
                                <h6 class="mb-0">Berkas Terunggah</h6>
                            </div>
                            <div class="card-body" id="file-gallery">
                                <p class="text-muted">Memuat data...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Catatan -->
                    <div class="modal fade" id="modalNotes" tabindex="-1">
                        <div class="modal-dialog bg-danger-focus">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>
                                </div>
                                <div class="modal-body">
                                    <textarea id="note-text" class="form-control" rows="4"></textarea>
                                    <input type="hidden" id="note-type">
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" id="save-note">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    let table = new DataTable('#dataTable', {
        responsive: true,
        columnDefs: [{
                targets: 4,
                name: 'filter-sekolah'
            },
            {
                targets: 6,
                name: 'filter-cabor'
            },
            {
                targets: 2,
                name: 'filter-status'
            }
        ]
    });

    $('#filter_cabor, #filter_sekolah, #filter_status').on('change', function() {

        let cabor = $('#filter_cabor option:selected').data('nama');
        let sekolah = $('#filter_sekolah option:selected').data('nama');
        let status = $('#filter_status option:selected').data('status');

        table.columns().search("");

        if (cabor) {
            table.column('filter-cabor:name').search(cabor, true, false);
        }

        if (sekolah) {
            table.column('filter-sekolah:name').search(sekolah, true, false);
        }

        if (status) {
            table.column('filter-status:name').search(status, true, false);
        }

        table.draw();
    });

    // view detail atlet
    $('.view-atlet').click(function() {

        const atletId = $(this).data('id');

        function detectImageSize() {
            // Cari semua link view-img yang belum punya ukuran
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
            url: "<?= site_url('api/get_detail_atlet'); ?>",
            method: "GET",
            data: {
                id: atletId
            },
            success: function(res) {
                // ============================================
                // SET DATA ATLET
                // ============================================
                $("#v-nama").text(res.data.nama);
                $("#v-nisn").text(res.data.nisn);
                $("#v-nik").text(res.data.nik);
                $("#v-sekolah").text(res.data.sekolah);
                $("#v-cabor").text(res.data.cabor);
                $("#v-jk").text(res.data.jenis_kelamin);
                $("#v-ttl").text(res.data.tempat_lahir + ', ' + res.data.tanggal_lahir);
                $("#v-alamat").text(res.data.alamat);

                $('#viewAtletModal').modal('show');
                $("#file-gallery").html("<p class='text-muted'>Loading...</p>");

                // ============================================
                // GALLERY FILE
                // ============================================
                let html = "";

                if (res.data.file_kk)
                    html += templateFile("Kartu Keluarga", `<?= base_url('public/uploads/atlet/file_kk/'); ?>` + res.data.file_kk, res.validasi.kk_status, "kk", atletId);

                if (res.data.file_akte)
                    html += templateFile("Akte Kelahiran", `<?= base_url('public/uploads/atlet/file_akte/'); ?>` + res.data.file_akte, res.validasi.akte_status, "akte", atletId);

                if (res.data.file_foto)
                    html += templateFile("Foto Atlet", `<?= base_url('public/uploads/atlet/file_foto/'); ?>` + res.data.file_foto, res.validasi.foto_status, "foto", atletId);

                if (res.data.file_ijazah)
                    html += templateFile("Ijazah", `<?= base_url('public/uploads/atlet/file_ijazah/'); ?>` + res.data.file_ijazah, res.validasi.ijazah_status, "ijazah", atletId);

                if (res.data.file_nisn)
                    html += templateFile("NISN", `<?= base_url('public/uploads/atlet/file_nisn/'); ?>` + res.data.file_nisn, res.validasi.nisn_status, "nisn", atletId);

                if (res.data.file_ktp_kia)
                    html += templateFile("KTP/KIA", `<?= base_url('public/uploads/atlet/file_ktp_kia/'); ?>` + res.data.file_ktp_kia, res.validasi.ktp_kia_status, "ktp_kia", atletId);

                $("#file-gallery").html(html);
                detectImageSize();
                reInitGallery();
            }
        });
    });

    $(document).on('click', '.validate-file, .invalidate-file', function() {

        let atletId = $(this).data('atlet-id');
        let type = $(this).data('type');

        let dok = type + "_status";
        let status = $(this).hasClass('validate-file') ? 'valid' : 'invalid';
        let pesan = status === 'valid' ? 'Dokumen Berhasil Divalidasi.' : 'Status Dokumen Berhasil Diubah.';

        Swal.fire({
            title: status === 'valid' ? `Validasi dokumen ${type}?` : `Cabut validasi dokumen ${type}?`,
            icon: status === 'valid' ? 'info' : 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'valid' ? 'rgba(8, 184, 108, 1)' : '#d33',
            cancelButtonColor: '#93999f',
            confirmButtonText: status === 'valid' ? 'Validasi' : 'Cabut Validasi',
            cancelButtonText: 'Batal',
        }).then((result) => {

            if (result.isConfirmed) {
                // loader
                Swal.fire({
                    title: 'Sedang memproses...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // validasi dokumen
                $.ajax({
                    url: '<?= site_url('api/validasi-dokumen'); ?>',
                    method: 'GET',
                    data: {
                        atletID: atletId,
                        dok: dok,
                        status: status,
                    },
                    success: function() {

                        let badgeEl = $(`.badge-status[data-type="${type}"]`);

                        if (status === 'valid') {
                            badgeEl.removeClass().addClass('badge badge-status bg-success').text('Valid');
                        } else {
                            badgeEl.removeClass().addClass('badge badge-status bg-danger').text('Tidak Valid');
                        }

                        Swal.fire({
                            title: pesan,
                            icon: "success",
                            allowOutsideClick: false,
                        }).then((result) => {

                            if (!result.isConfirmed) return;

                            const dokumenWajib = [
                                'kk_status',
                                'akte_status',
                                'foto_status',
                                'ktp_kia_status',
                                'nisn_status'
                            ];

                            function isDokumenValid(data) {
                                const wajibValid = dokumenWajib.every(key => data[key] === "valid");
                                const ijazahOK = (data.ijazah_status === "valid" || data.ijazah_status === "pending");
                                return wajibValid && ijazahOK;
                            }

                            const badgeDepan = $(`.badge-status-depan[data-id="${atletId}"]`);

                            // loader
                            // Swal.fire({
                            //     title: 'Memeriksa status akhir...',
                            //     allowOutsideClick: false,
                            //     didOpen: () => Swal.showLoading()
                            // });

                            $.ajax({
                                url: `<?= site_url('api/validasi-atlet'); ?>`,
                                method: 'GET',
                                data: {
                                    atletID: atletId
                                },
                                success: function(data) {

                                    const statusFinal = isDokumenValid(data) ? "valid" : "invalid";

                                    $.ajax({
                                        url: `<?= site_url('api/set-atlet-valid'); ?>`,
                                        method: 'POST',
                                        data: {
                                            atletID: atletId,
                                            status: statusFinal
                                        },
                                        complete: function() {
                                            Swal.close(); // Tutup loader
                                        }
                                    });

                                    if (statusFinal === "valid") {
                                        badgeDepan
                                            .removeClass()
                                            .addClass('badge badge-status-depan bg-success')
                                            .text('Valid');
                                    } else {
                                        badgeDepan
                                            .removeClass()
                                            .addClass('badge badge-status-depan bg-warning text-dark')
                                            .text('Belum Valid');
                                    }
                                }
                            });
                        });
                    }
                });
            }
        });
    });

    $(document).on("click", ".view-pdf", function() {
        let url = $(this).data("file");
        $("#previewContent").html(`
            <iframe src="${url}" style="width:100%; height:80vh;" frameborder="0"></iframe>`);
        $("#previewModal").modal("show");
    });

    // buka modal catatan
    $(document).on('click', '.notes-file', function() {

        $('.modal-title').text('Catatan ' + $(this).data('label'));
        $('#modalNotes').modal('show');

        let atletID = $(this).data('id');
        let type = $(this).data('type');

        // Buat nama field catatan dan status
        let dok_catatan = type + '_catatan';

        // kosongkan textarea
        $('#note-text').val('');

        // Ambil catatan lama dari DB
        $.ajax({
            url: `<?= site_url('api/get-catatan'); ?>`,
            method: 'POST',
            data: {
                atlet_id: atletID,
                dok_catatan: dok_catatan
            },
            success: function(res) {
                if (res && res[dok_catatan]) {
                    $('#note-text').val(res[dok_catatan]);
                }
            }
        });

        // Simpan ID dan field yang dipakai ke modal
        $('#modalNotes').data('atlet-id', atletID);
        $('#modalNotes').data('dok-catatan', dok_catatan);
    });


    // EVENT SUBMIT (HANYA DI-BIND SEKALI)
    $('button[type="submit"]').off('click').on('click', function() {

        let atletID = $('#modalNotes').data('atlet-id');
        let dok_catatan = $('#modalNotes').data('dok-catatan');
        let note_value = $('#note-text').val();

        $.ajax({
            url: `<?= site_url('api/simpan-catatan'); ?>`,
            method: 'POST',
            data: {
                atlet_id: atletID,
                dok_catatan: dok_catatan,
                note_value: note_value
            },
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: "Berhasil",
                        text: res.message,
                        icon: "success"
                    }).then(() => {
                        $('#modalNotes').modal('hide');
                    });
                }
            }
        });
    });



    // delete atlet
    $(document).on('click', '.delete-atlet', function() {
        let atletId = $(this).attr('id');

        Swal.fire({
            title: "Yakin Hapus Data Atlet Tersebut?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#93999f',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('sekolah/atlet/delete/'); ?>" + atletId;
            }
        });
    });
</script>

<?= $this->endSection(); ?>