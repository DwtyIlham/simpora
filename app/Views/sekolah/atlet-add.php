<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    tr>th,
    td {
        vertical-align: middle;
    }
</style>

<div class="col-md-12">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Tambah Data Atlet Pelajar</h5>
        </div>

        <form id="wizardForm" action="<?= site_url('sekolah/atlet/add'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="card-body">

                <!-- STEP INDICATOR / TABS -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <div id="tabStep1" class="step-tab active">1. Data Atlet</div>
                        <div id="tabStep2" class="step-tab">2. Lampiran</div>
                    </div>
                </div>

                <!-- STEP 1: DATA ATLET -->
                <div id="step1">
                    <table class="table table-borderless align-middle">
                        <tbody>
                            <tr>
                                <th class="w-25 text-end">Asal Sekolah</th>
                                <td>
                                    <input type="text" class="form-control" value="<?= $sekolah['nama']; ?>" readonly>
                                    <input type="hidden" name="sekolah" value="<?= $sekolah['id']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">NIK</th>
                                <td>
                                    <input type="text" name="nik" class="form-control" maxlength="16" minlength="16"
                                        placeholder="Masukkan NIK (16 digit)" value="<?= set_value('nik', old('nik') ?? @$atlet['nik']); ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Cabang Olahraga</th>
                                <td>
                                    <select name="cabor" class="form-select" required>
                                        <option value="">-- Pilih Cabang Olahraga --</option>
                                        <?php foreach ($cabor as $c): ?>
                                            <option value="<?= $c['id']; ?>" <?= (old('cabor') == $c['id'] || @$atlet['cabor_id'] == $c['id']) ? 'selected' : '' ?>>
                                                <?= $c['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">NISN</th>
                                <td>
                                    <input type="text" name="nisn" class="form-control" minlength="10" maxlength="10"
                                        placeholder="Masukkan NISN (10 digit)" value="<?= set_value('nisn', old('nisn') ?? @$atlet['nisn']); ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Nama Lengkap</th>
                                <td>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Nama sesuai KK" value="<?= set_value('nama', old('nama') ?? @$atlet['nama']); ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Jenis Kelamin</th>
                                <td>
                                    <select class="form-select" name="jk" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= (old('jk') == 'L' || @$atlet['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                                        <option value="P" <?= (old('jk') == 'P' || @$atlet['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Tempat Lahir</th>
                                <td>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        placeholder="Kota/Kabupaten lahir" value="<?= set_value('tempat_lahir', old('tempat_lahir') ?? @$atlet['tempat_lahir']); ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Tanggal Lahir</th>
                                <td>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">Alamat</th>
                                <td>
                                    <input type="text" name="alamat" class="form-control"
                                        placeholder="Alamat lengkap rumah" value="<?= set_value('alamat', old('alamat') ?? @$atlet['alamat']); ?>" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-primary" id="toStep2">Lanjut &rarr;</button>
                    </div>
                </div>

                <!-- STEP 2: FILE / LAMPIRAN -->
                <div id="step2" style="display: none;">
                    <table class="table table-borderless align-middle">
                        <tbody>
                            <?php
                            $files = [
                                // ['label' => 'KK', 'name' => 'file_kk', 'required' => true],
                                ['label' => 'KTP / KIA / KK', 'name' => 'file_ktp_kia_kk', 'required' => true],
                                ['label' => 'NISN', 'name' => 'file_nisn', 'required' => true],
                                ['label' => 'Akte', 'name' => 'file_akte', 'required' => true],
                                ['label' => 'Foto', 'name' => 'file_foto', 'required' => true],
                                ['label' => 'Ijazah (Opsional)', 'name' => 'file_ijazah', 'required' => false],
                                // ['label' => 'Surat Keterangan', 'name' => 'file_surat_keterangan', 'required' => false],
                            ];
                            foreach ($files as $f): ?>
                                <tr>
                                    <th class="text-end"><?= $f['label'] ?> <?= $f['required'] ? '<span class="text-danger">*</span>' : '' ?></th>
                                    <td>
                                        <input type="file" name="<?= $f['name'] ?>" class="form-control" accept=".jpg,.jpeg,.png,.webp" <?= $f['required'] ? 'required' : '' ?>>
                                        <small class="text-muted">JPG, JPEG, PNG, WEBP • 100KB - 2MB</small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th class="text-end">Surat Keterangan <span class="text-danger">*</span></th>
                                <td>
                                    <input type="file" name="file_suket" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                                    <!-- <small class="text-muted">PDF • 100KB - 2MB</small> -->
                                    <small class="text-muted">JPG, JPEG, PNG, WEBP • 100KB - 2MB</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary me-2" id="backStep1">&larr; Kembali</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- TAB STYLES -->
<style>
    .step-tab {
        flex: 1;
        text-align: center;
        padding: 10px 0;
        border-bottom: 3px solid #dee2e6;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .step-tab.active {
        border-bottom: 3px solid #0d6efd;
        /* Bootstrap primary color */
        color: #0d6efd;
    }

    .step-tab.completed {
        color: #198754;
        /* Green for completed */
    }
</style>

<script>
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const toStep2 = document.getElementById('toStep2');
    const backStep1 = document.getElementById('backStep1');

    const tabStep1 = document.getElementById('tabStep1');
    const tabStep2 = document.getElementById('tabStep2');

    toStep2.addEventListener('click', () => {
        const inputs = step1.querySelectorAll('input, select');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });

        if (valid) {
            step1.style.display = 'none';
            step2.style.display = 'block';

            tabStep1.classList.remove('active');
            tabStep1.classList.add('completed');
            tabStep2.classList.add('active');
        }
    });

    backStep1.addEventListener('click', () => {
        step2.style.display = 'none';
        step1.style.display = 'block';

        tabStep2.classList.remove('active');
        tabStep1.classList.remove('completed');
        tabStep1.classList.add('active');
    });
</script>

<?= $this->endSection(); ?>