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
                <h5 class="card-title mb-0"><?= $title; ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table id="tableData" class="table table-bordered table-hover table-striped dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">No.</th>
                            <th style="width:15%" class="text-start">Nama</th>
                            <th style="width:25%" class="text-start">Deskripsi</th>
                            <th style="width:10%" class="text-center">Tgl Mulai</th>
                            <th style="width:10%" class="text-center">Tgl Selesai</th>
                            <th style="width:10%" class="text-center">Tingkat</th>
                            <th style="width:10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($kompetisi as $k): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no; ?></td>
                                <td class="align-middle"><?= $k['nama']; ?></td>
                                <td class="align-middle" style="text-align: left;"><?= $k['deskripsi']; ?></td>
                                <td class="text-center align-middle"><?= format_tgl($k['tgl_start']); ?></td>
                                <td class="text-center align-middle"><?= format_tgl($k['tgl_end']); ?></td>
                                <td class="text-center align-middle"><?= strtoupper($k['tingkat']); ?></td>
                                <td class="text-center align-middle">
                                    <a href="<?= site_url('sekolah/kompetisi/peserta/') . $k['id']; ?>"
                                        class="btn-view-idcard w-32-px h-32-px bg-primary-100 text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Peserta Kompetisi">
                                        <iconify-icon icon="lucide:scan-eye"></iconify-icon>
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

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    // delete kompetisi
    $(document).on('click', '.btn-delete', function() {
        let kompetisiId = $(this).attr('id');

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
                window.location.href = "<?= base_url('admin/kompetisi/delete/'); ?>" + kompetisiId;
            }
        });
    });
</script>

<?= $this->endSection(); ?>