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
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="card-title mb-0"><?= $title; ?></h5>
                <?php if (isAdmin()) : ?>
                    <a href="javascript:void(0)" class="btn btn-primary-600" data-bs-toggle="modal" data-bs-target="#modalAddNomorCabor"><i class="ri-add-box-line"></i> Tambah Nomor Cabor</a>
                    <!-- modal tambah nomor cabor -->
                    <div class="modal fade" id="modalAddNomorCabor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Nomor Cabor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= site_url('admin/kompetisi/nomor-cabor/add'); ?>" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <select class="form-select select2" id="cabor_id" name="cabor_id" data-placeholder="Pilih Cabang Olahraga" required>
                                                <option value="" selected disabled>Pilih Cabang Olahraga</option>
                                                <?php foreach ($cabor as $c): ?>
                                                    <option value="<?= $c['id']; ?>"><?= $c['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Nomor Cabor</label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan Nama Nomor Cabor" autocomplete="off" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenjang_id" class="form-label">Jenjang Nomor Cabor</label>
                                            <select name="jenjang_id" id="jenjang_id" class="form-select" required>
                                                <option value="">- Pilih Jenjang -</option>
                                                <?php foreach ($jenjang as $j): ?>
                                                    <option value="<?= $j['id']; ?>"><?= $j['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Kategori Nomor Cabor</label>
                                            <select name="kategori" id="kategori" class="form-select" required>
                                                <option value="">- Pilih Kategori -</option>
                                                <option value="Putra">Putra</option>
                                                <option value="Putri">Putri</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="detail">Detail</label>
                                            <input type="text" class="form-control" name="detail" placeholder="Isikan Detail Nomor Cabor (Opsional)" autocomplete="off">
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
                <?php endif; ?>
            </div>
            <div class="card-body table-responsive data-table-shell">
                <table id="dataTable" class="table table-data table-data-wide" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-start col-no" width="20px">No.</th>
                            <th class="text-start col-nama">Nama</th>
                            <th class="text-start col-jenjang">Jenjang</th>
                            <th class="text-start col-kategori">Kategori</th>
                            <th class="text-start col-detail">Detail</th>
                            <th class="text-start col-cabor">Cabor</th>
                            <?php if (isAdmin()): ?>
                                <th class="text-center col-aksi">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($nomcab as $nc): ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?>.</td>
                                <td><?= $nc['nama'] ?></td>
                                <td><?= $nc['jenjang']; ?></td>
                                <td><?= $nc['kategori']; ?></td>
                                <td><?= $nc['detail'] == '' ? '-' : $nc['detail']; ?></td>
                                <td><?= $nc['cabor']; ?></td>
                                <td class="align-middle">
                                    <?php if (isAdmin()): ?>
                                        <a href="javascript:void(0)"
                                            class="btn-edit w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditNomorCabor"
                                            data-id="<?= $nc['id']; ?>">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>

                                        <a id="<?= $nc['id']; ?>" class="btn-delete w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditNomorCabor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nomor Cabor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Action form dikosongkan, akan diisi via JS -->
            <form id="formEditCabor" action="" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cabang Olahraga</label>
                        <select class="form-select select2" id="edit_cabor_id" name="cabor_id" required>
                            <?php foreach ($cabor as $c): ?>
                                <option value="<?= $c['id']; ?>"><?= $c['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Nomor Cabor</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select name="jenjang_id" id="edit_jenjang" class="form-select" required>
                            <option value="">- Pilih Jenjang -</option>
                            <?php foreach ($jenjang as $j): ?>
                                <option value="<?= $j['id']; ?>"><?= $j['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="edit_kategori" class="form-select" required>
                            <option value="Putra">Putra</option>
                            <option value="Putri">Putri</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="detail">Detail (Opsional)</label>
                        <input type="text" class="form-control" id="edit_detail" name="detail">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('public/assets/js/gallery.js'); ?>"></script>

<script>
    let table = new DataTable('#dataTable', {
        responsive: false,
        autoWidth: false,
        order: [],
    });

    $(document).on('shown.bs.modal', function() {
        $('#cabor_id').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalAddNomorCabor')
        });
        $('#edit_cabor_id').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modalEditNomorCabor'),
        });
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

    // edit nomor cabor
    $(document).on('click', '.btn-edit', function() {
        // 1. Ambil data dari baris tabel
        let id = $(this).data('id');
        let nama = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        let jenjang = $(this).closest('tr').find('td:nth-child(3)').text().trim();
        let kategori = $(this).closest('tr').find('td:nth-child(4)').text().trim();
        let detail = $(this).closest('tr').find('td:nth-child(5)').text().trim();
        let cabor = $(this).closest('tr').find('td:nth-child(6)').text().trim();

        // 2. Update Action Form secara dinamis
        // Sesuaikan base_url jika perlu, di sini saya asumsikan mengikuti pola URL Anda
        let actionUrl = "<?= site_url('admin/kompetisi/nomor-cabor/edit/'); ?>" + id;
        $('#formEditCabor').attr('action', actionUrl);

        // 3. Isi input field
        $('#edit_id').val(id);
        $('#edit_nama').val(nama);
        $('#edit_detail').val(detail === '-' ? '' : detail);

        // 4. Pilih Option berdasarkan TEXT untuk Select2/Dropdown
        $('#edit_cabor_id option').filter(function() {
            return $(this).text().trim() === cabor;
        }).prop('selected', true).trigger('change');

        $('#edit_jenjang option').filter(function() {
            return $(this).text().trim() === jenjang;
        }).prop('selected', true);

        $('#edit_kategori').val(kategori);
    });

    // delete nomor cabor
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).attr('id');

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
                window.location.href = "<?= base_url('admin/nomorcabor/delete/'); ?>" + id;
            }
        });
    });
</script>

<?= $this->endSection(); ?>