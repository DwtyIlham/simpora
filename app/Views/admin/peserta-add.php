<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"><?= $title; ?></h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
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
        <div class="card">
            <div class="card-header">
                <a onclick="history.back(-1)" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Kembali</a>
            </div>
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= $title; ?></h5>
            </div>
            <!-- Form kompetisi Administrator Dinas -->
            <form action="<?= base_url('admin/kompetisi/peserta/add') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row gy-2">
                        <div class="col-6">
                            <label class="form-label">Nama Kompetisi</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="carbon:event"></iconify-icon>
                                </span>
                                <input type="text" class="form-control" value="<?= $kompetisi ?>" autocomplete="off" readonly>
                                <input type="hidden" name="kompetisi" class="form-control" value="<?= set_value('kompetisi', $id_kompetisi); ?>" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pilih Cabor</label>
                            <select class="form-select select2" name="cabor" id="cabor" data-placeholder="Pilih Cabor" required>
                                <option></option>
                                <?php foreach ($cabor as $c): ?>
                                    <option value="<?= $c['id']; ?>"><?= $c['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pilih Nomor Cabor</label>
                            <div class="icon-field">
                                <select name="nomor_cabor" id="nomor_cabor" class="form-select select2" data-placeholder="Pilih Nomor Cabor" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pilih Atlet</label>
                            <select class="form-select select2" name="atlet[]" id="atlet" data-placeholder="Ketik/Pilih Atlet" multiple>
                                <option></option>
                                <?php foreach ($atlet as $a): ?>
                                    <option value="<?= $a['id']; ?>"><?= $a['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button role="submit" class="btn btn-primary-600"><i class="ri-save-line"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End of Form kompetisi Administrator Dinas -->
    </div>
</div>

<script>
    let table = new DataTable('#dataTable');
    const selectRole = document.getElementById('select-role');
    const form1 = document.querySelector('.form-1');
    const form2 = document.querySelector('.form-2');
    $('#select-role').on('change', function() {
        const selectedValue = this.value;

        if (selectedValue === '1') {
            form1.classList.remove('d-none');
            form2.classList.add('d-none');
        } else if (selectedValue === '2') {
            form2.classList.remove('d-none');
            form1.classList.add('d-none');
        } else {
            form1.classList.add('d-none');
            form2.classList.add('d-none');
        }
    });

    // load nomor cabor berdasar cabor terpilih
    $('#cabor').on('change', function() {
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