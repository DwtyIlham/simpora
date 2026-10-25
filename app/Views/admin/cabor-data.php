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
            <a href="<?= site_url('admin/kompetisi/cabor'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
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
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><?= $title; ?></h5>
                <?php if (isAdmin()) : ?>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalAddCabor" class="btn btn-primary-600"><i class="ri-add-box-line"></i> Tambah Cabor</a>
                    <!-- modal tambah cabor -->
                    <div class="modal fade" id="modalAddCabor" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Cabor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= base_url('admin/cabor/add'); ?>" method="post">
                                    <div class="modal-body">
                                        <?= csrf_field(); ?>
                                        <input type="text" name="nama_cabor" class="form-control" placeholder="Nama Cabang Olahraga Baru" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body table-responsive">
                <table id="dataTable" class="table" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-start" width="20px">No.</th>
                            <th class="text-start" width="80%">Nama</th>
                            <?php if (isAdmin()): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($cabor as $c): ?>
                            <tr>
                                <td class="text-start align-middle"><?= $no; ?>.</td>
                                <td class="align-middle">
                                    <a href="javascript:void(0)" class="btn btn-outline-primary col-12" data-bs-toggle="modal" data-bs-target="#modal-nocab-<?= $c['id'] ?>"><?= $c['nama']; ?></a>
                                    <!-- Modal Nomor Cabor -->
                                    <div class="modal fade" id="modal-nocab-<?= $c['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow-sm rounded-4">

                                                <!-- Header -->
                                                <div class="modal-header border-0 pb-0">
                                                    <div>
                                                        <h5 class="modal-title fw-bold mb-1">
                                                            Data Nomor Cabor
                                                        </h5>
                                                        <small class="text-muted">
                                                            Kelola status nomor cabang olahraga
                                                        </small>
                                                    </div>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body pt-3">

                                                    <?php
                                                    // grouping per jenjang
                                                    $grouped = [];

                                                    foreach ($nomcab as $nc) {
                                                        if ($c['id'] == $nc['cabor_id']) {
                                                            $grouped[$nc['jenjang']][] = $nc;
                                                        }
                                                    }
                                                    ?>

                                                    <?php foreach ($grouped as $jenjang => $items): ?>

                                                        <div class="border rounded-4 p-3 mb-4">

                                                            <!-- Header Jenjang -->
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <div>
                                                                    <h6 class="fw-semibold mb-0">
                                                                        <?= $jenjang ?>
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        <?= count($items) ?> nomor
                                                                    </small>
                                                                </div>

                                                                <!-- Toggle per jenjang -->
                                                                <button
                                                                    class="btn-toggle-jenjang btn btn-sm btn-primary rounded-pill px-3"
                                                                    data-jenjang="<?= $jenjang ?>">
                                                                    Ganti Status <?= $jenjang; ?>
                                                                </button>
                                                            </div>

                                                            <!-- List Item -->
                                                            <div class="d-flex flex-column gap-2">

                                                                <?php foreach ($items as $nc): ?>

                                                                    <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center">

                                                                        <!-- Info -->
                                                                        <div>
                                                                            <div class="fw-medium">
                                                                                <?= $nc['nama'] ?>
                                                                            </div>

                                                                            <small class="text-muted">
                                                                                <?= $nc['kategori'] ?>
                                                                                <?= !empty($nc['detail']) ? '• ' . $nc['detail'] : '' ?>
                                                                            </small>
                                                                        </div>

                                                                        <!-- Action -->
                                                                        <div class="d-flex align-items-center gap-3">

                                                                            <!-- Badge -->
                                                                            <span class="badge rounded-pill bg-<?= $nc['is_active'] == '1' ? 'success' : 'secondary' ?>">
                                                                                <?= $nc['is_active'] == '1' ? 'Aktif' : 'Nonaktif' ?>
                                                                            </span>

                                                                            <!-- Toggle Item -->
                                                                            <div class="form-check form-switch m-0">
                                                                                <input
                                                                                    class="form-check-input btn-status-nocab"
                                                                                    type="checkbox"
                                                                                    role="switch"
                                                                                    data-id="<?= $nc['id']; ?>"
                                                                                    <?= $nc['is_active'] == '1' ? 'checked' : ''; ?>>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                <?php endforeach; ?>

                                                            </div>

                                                        </div>

                                                    <?php endforeach; ?>

                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if (isAdmin()): ?>
                                        <a href="javascript:void(0)" class="btn-edit w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                            data-id="<?= $c['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalEditCabor">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>

                                        <!-- modal edit cabor -->
                                        <div class="modal fade" id="modalEditCabor" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="formEditCabor" action="<?= base_url('admin/kompetisi/editCabor'); ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" id="id" name="id">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Cabor</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label>Nama Cabor Lama</label>
                                                                <input type="text" class="form-control" id="cabor-lama" name="cabor_lama" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label>Nama Cabor Baru</label>
                                                                <input type="text" class="form-control" id="cabor-baru" name="cabor_baru">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <a id="<?= $c['id']; ?>" class="btn-delete  w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    <?php endif; ?>
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

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    let table = new DataTable('#dataTable', {
        responsive: true
    });

    // toggle status nomor cabor
    // $(document).on('click', '.btn-status-nocab', function() {
    //     let btn = $(this);
    //     let nomorCaborId = btn.data('id');
    //     let currentStatus = btn.data('status');
    //     let newStatus = currentStatus == '1' ? '0' : '1';

    //     let statusText = newStatus == '1' ? 'Aktif' : 'Tidak Aktif';
    //     let statusClass = newStatus == '1' ? 'success' : 'danger';
    //     let btnClass = newStatus == '1' ? 'danger' : 'success';
    //     let icon = newStatus == '1' ? 'carbon:close-outline' : 'carbon:checkmark-outline';

    //     Swal.fire({
    //         title: `Yakin Ubah Status Menjadi ${statusText}?`,
    //         icon: "question",
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#93999f',
    //         confirmButtonText: 'Ya, Ubah!',
    //         cancelButtonText: 'Batal',
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: "<?= base_url('api/toggle-nomor-cabor-status'); ?>",
    //                 type: "POST",
    //                 data: {
    //                     id: nomorCaborId,
    //                     status: newStatus
    //                 },
    //                 success: function() {

    //                     btn.data('status', newStatus);

    //                     btn.closest('td')
    //                         .prev('td')
    //                         .find('span')
    //                         .text(statusText)
    //                         .removeClass('bg-success-focus bg-danger-focus text-success-main text-danger-main')
    //                         .addClass(`bg-${statusClass}-focus text-${statusClass}-main`);

    //                     btn.removeClass('bg-success-focus bg-danger-focus text-success-main text-danger-main')
    //                         .addClass(`bg-${btnClass}-focus text-${btnClass}-main`);

    //                     btn.find('iconify-icon').attr('icon', icon);

    //                     Swal.fire({
    //                         title: 'Berhasil!',
    //                         text: `Status Nomor Cabor Berhasil Diubah Menjadi ${statusText}.`,
    //                         icon: 'success',
    //                         confirmButtonColor: '#3085d6',
    //                     });
    //                 },
    //                 error: function() {
    //                     Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status.', 'error');
    //                 }
    //             });
    //         }
    //     });
    // });

    $(document).on('change', '.btn-status-nocab', function() {

        const checkbox = $(this);
        const id = checkbox.data('id');
        const status = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: '<?= site_url('api/toggle-nomor-cabor-per-item'); ?>',
            type: 'POST',
            data: {
                id: id,
                status: status
            },

            beforeSend: function() {

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Sedang memperbarui status',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

            },

            success: function(response) {

                Swal.close();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Status berhasil diperbarui',
                    timer: 1500,
                    showConfirmButton: false
                });

                // cari badge terdekat
                const badge = checkbox
                    .closest('.d-flex.align-items-center.gap-3')
                    .find('.badge');

                if (status == 1) {

                    badge
                        .removeClass('bg-secondary')
                        .addClass('bg-success')
                        .text('Aktif');

                } else {

                    badge
                        .removeClass('bg-success')
                        .addClass('bg-secondary')
                        .text('Nonaktif');

                }

            },

            error: function() {

                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat update status'
                });

                // rollback switch
                checkbox.prop('checked', !status);

            }

        });

    });

    $(document).on('click', '.btn-toggle-jenjang', function() {

        let parent = $(this).closest('.border');
        let switches = parent.find('.btn-status-nocab');

        let allChecked = true;

        switches.each(function() {
            if (!$(this).is(':checked')) {
                allChecked = false;
            }
        });

        switches.prop('checked', !allChecked).trigger('change');

    });

    // edit cabor
    $(document).on('click', '.btn-edit', function() {
        let btn = $(this);
        let nama_cabor_lama = btn.closest('tr').find('td').eq(1).find('a').text().trim();
        let id = btn.data('id');
        $('#id').val(id);
        $('#cabor-lama').val(nama_cabor_lama);
        $('#cabor-baru').val(nama_cabor_lama);
    })

    // delete cabor
    $(document).on('click', '.btn-delete', function() {
        let caborID = $(this).attr('id');

        Swal.fire({
            title: "Yakin Hapus Data Cabor Tersebut?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#93999f',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/cabor/delete/'); ?>" + caborID;
            }
        });
    });
</script>

<?= $this->endSection(); ?>