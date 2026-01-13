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
            <a href="<?= site_url('admin/cabor/data'); ?>" class="d-flex align-items-center gap-1 hover-text-primary">
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
                                    <div class="modal fade" id="modal-nocab-<?= $c['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Data Nomor Cabor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Nomor Cabor</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($nomcab as $nc): ?>
                                                            <?php if ($c['id'] == $nc['cabor_id']):
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $nc['nama'] . ' ' . $nc['jenjang'] . ' ' . $nc['kategori'] . ' ' . $nc['detail'] ?? '-'; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="btn text-sm bg-<?= $nc['is_active'] == '1' ? 'success' : 'danger'; ?>-focus text-<?= $nc['is_active'] == '1' ? 'success' : 'danger'; ?>-main p-2">
                                                                            <?= $nc['is_active'] == '1' ? 'Aktif' : 'Tidak Aktif '; ?>
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button
                                                                            data-id="<?= $nc['id']; ?>" data-status="<?= $nc['is_active']; ?>"
                                                                            class="btn-status-nocab w-32-px h-32-px bg-<?= $nc['is_active'] == '1' ? 'danger' : 'success'; ?>-focus text-<?= $nc['is_active'] == '1' ? 'danger' : 'success'; ?>-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                                            <iconify-icon icon="carbon:<?= $nc['is_active'] == '1' ? 'close-outline' : 'checkmark-outline'; ?>"></iconify-icon>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
    $(document).on('click', '.btn-status-nocab', function() {
        let btn = $(this);
        let nomorCaborId = btn.data('id');
        let currentStatus = btn.data('status');
        let newStatus = currentStatus == '1' ? '0' : '1';

        let statusText = newStatus == '1' ? 'Aktif' : 'Tidak Aktif';
        let statusClass = newStatus == '1' ? 'success' : 'danger';
        let btnClass = newStatus == '1' ? 'danger' : 'success';
        let icon = newStatus == '1' ? 'carbon:close-outline' : 'carbon:checkmark-outline';

        Swal.fire({
            title: `Yakin Ubah Status Menjadi ${statusText}?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#93999f',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('api/toggle-nomor-cabor-status'); ?>",
                    type: "POST",
                    data: {
                        id: nomorCaborId,
                        status: newStatus
                    },
                    success: function() {

                        btn.data('status', newStatus);

                        btn.closest('td')
                            .prev('td')
                            .find('span')
                            .text(statusText)
                            .removeClass('bg-success-focus bg-danger-focus text-success-main text-danger-main')
                            .addClass(`bg-${statusClass}-focus text-${statusClass}-main`);

                        btn.removeClass('bg-success-focus bg-danger-focus text-success-main text-danger-main')
                            .addClass(`bg-${btnClass}-focus text-${btnClass}-main`);

                        btn.find('iconify-icon').attr('icon', icon);

                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Status Nomor Cabor Berhasil Diubah Menjadi ${statusText}.`,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                        });
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status.', 'error');
                    }
                });
            }
        });
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