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
                <a onclick="history.back(-1)" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600"><i class="ri-arrow-go-back-line"></i> Daftar Atlet Prestasi</a>
            </div>
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= $title; ?></h5>
            </div>
            <!-- Form kompetisi Administrator Dinas -->
            <form action="<?= base_url('admin/kompetisi/prestasi-add') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row gy-2">
                        <div class="col-12">
                            <label class="form-label">Nama Kompetisi</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="carbon:event"></iconify-icon>
                                </span>
                                <input type="text" class="form-control" value="<?= $kompetisi ?>" autocomplete="off" readonly>
                                <input type="hidden" name="kompetisi_id" class="form-control" value="<?= set_value('kompetisi', $id_kompetisi); ?>" autocomplete="off" readonly>
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
                            <label class="form-label">Pilih Sekolah</label>
                            <select class="form-select select2" name="sekolah_id" id="sekolah" data-placeholder="Pilih Sekolah" required>
                                <option></option>
                                <?php foreach ($sekolah as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= $s['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pilih Atlet</label>
                            <select class="form-select select2" name="peserta_id" id="atlet" data-placeholder="Ketik/Pilih Atlet" disabled>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pilih Prestasi</label>
                            <select class="form-select" name="prestasi_id" id="prestasi" disabled>
                                <option selected disabled>- Pilih Prestasi-</option>
                                <option value="1">Emas</option>
                                <option value="2">Perak</option>
                                <option value="3">Perunggu</option>
                            </select>
                        </div>
                        <div class="col-12 mt-12">
                            <button role="submit" class="btn btn-primary-600"><i class="ri-save-line"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let cabor_id, sekolah_id, cabor, sekolah;
    $(document).on('change', '#cabor, #sekolah', function() {
        cabor_id = $('#cabor').val();
        cabor = $(this).find('option:selected').text();
        sekolah_id = $('#sekolah').val();
        sekolah = $(this).find('option:selected').text();

        if (cabor_id || sekolah_id) {
            getAtletValue(cabor_id, sekolah_id);
        }

    });

    function getAtletValue(cabor_id, sekolah_id) {
        $('#atlet').empty();
        $('#atlet').append(`<option>-Pilih Atlet-</option>`);
        $.ajax({
            url: `<?= site_url('api/get-peserta-kompetisi-caborsekolah/'); ?>${cabor_id}/${sekolah_id}`,
            method: 'get',
            success: function(res) {
                if (res.length > 0) {
                    $('#atlet').attr('disabled', false);
                    $('#prestasi').attr('disabled', false);
                } else {
                    $('#atlet').attr('disabled', true);
                    $('#prestasi').attr('disabled', true);
                }
                $.each(res, function(i, v) {
                    $('#atlet').append(`
                    <option value="${v.id}">${v.nama}</option>
                    `);
                })
            }
        });
    }

    $('#atlet').change(function() {
        console.log($(this).val() ?? $(this).find('option:selected'));
    });
</script>

<?= $this->endSection(); ?>