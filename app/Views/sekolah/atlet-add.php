<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$isEdit          = !empty($atlet);
$bentukSekolah   = $sekolah['bentuk_pendidikan'] ?? '';
$isIjazahWajib   = !in_array($bentukSekolah, ['SD', 'MI']);
$jkTerpilih      = old('jk') ?? ($atlet['jenis_kelamin'] ?? '');
$oldValue        = static function ($key, $fallback = '') {
    $value = old($key);
    return $value !== null ? $value : $fallback;
};

$daftarBerkas = [
    [
        'label'    => 'KTP / KIA / KK',
        'name'     => 'file_ktp_kia_kk',
        'icon'     => 'lucide:id-card',
        'desc'     => 'Kartu identitas atau Kartu Keluarga',
        'required' => true,
    ],
    [
        'label'    => 'Kartu NISN',
        'name'     => 'file_nisn',
        'icon'     => 'lucide:badge-check',
        'desc'     => 'Bukti kepemilikan NISN',
        'required' => true,
    ],
    [
        'label'    => 'Akte Kelahiran',
        'name'     => 'file_akte',
        'icon'     => 'lucide:baby',
        'desc'     => 'Akte kelahiran asli / legalisir',
        'required' => true,
    ],
    [
        'label'    => 'Foto Atlet',
        'name'     => 'file_foto',
        'icon'     => 'lucide:user-round',
        'desc'     => 'Pas foto terbaru, latar belakang polos',
        'required' => true,
    ],
    [
        'label'    => 'Ijazah',
        'name'     => 'file_ijazah',
        'icon'     => 'lucide:graduation-cap',
        'desc'     => $isIjazahWajib ? 'Wajib untuk jenjang selain SD / MI' : 'Opsional untuk jenjang SD / MI',
        'required' => $isIjazahWajib,
    ],
    [
        'label'    => 'Surat Keterangan',
        'name'     => 'file_suket',
        'icon'     => 'lucide:file-check-2',
        'desc'     => 'Surat keterangan aktif sebagai pelajar',
        'required' => true,
    ],
];
?>

<style>
    .atlet-wizard-card {
        border: 0;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .atlet-steps {
        display: flex;
        gap: 10px;
    }

    .atlet-step {
        flex: 1 1 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border: 1px solid var(--neutral-200, #e5e7eb);
        border-radius: 12px;
        background: #f8fafc;
        transition: all .2s ease;
    }

    .atlet-step__num {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .85rem;
        color: #475569;
        background: #e2e8f0;
        transition: all .2s ease;
    }

    .atlet-step__title {
        font-size: .875rem;
        font-weight: 600;
        line-height: 1.2;
        color: var(--text-primary-light, #0f172a);
    }

    .atlet-step__desc {
        font-size: .72rem;
        color: #64748b;
        line-height: 1.3;
    }

    .atlet-step.is-active {
        border-color: #bfdbfe;
        background: #eff6ff;
        box-shadow: 0 6px 18px rgba(37, 99, 235, .08);
    }

    .atlet-step.is-active .atlet-step__num {
        background: #2563eb;
        color: #fff;
    }

    .atlet-step.is-active .atlet-step__title {
        color: #1d4ed8;
    }

    .atlet-step.is-done {
        border-color: #bbf7d0;
        background: #f0fdf4;
    }

    .atlet-step.is-done .atlet-step__num {
        background: #16a34a;
        color: #fff;
    }

    .atlet-step.is-done .atlet-step__title {
        color: #15803d;
    }

    .atlet-step.is-clickable {
        cursor: pointer;
    }

    .atlet-step.is-clickable:hover {
        border-color: #93c5fd;
        transform: translateY(-1px);
    }

    .atlet-progress {
        height: 4px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .atlet-progress .progress-bar {
        background: linear-gradient(90deg, #2563eb, #3b82f6);
        transition: width .3s ease;
    }

    .wizard-section-head {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 18px;
        border-bottom: 1px dashed var(--neutral-200, #e5e7eb);
    }

    .wizard-section-head .icon-box {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: #eff6ff;
        color: #2563eb;
    }

    .wizard-section-head h6 {
        margin-bottom: 2px;
    }

    .atlet-wizard-card .form-label {
        font-weight: 600;
        font-size: .82rem;
        margin-bottom: .35rem;
    }

    .atlet-wizard-card .form-text,
    .atlet-wizard-card .form-hint {
        font-size: .74rem;
        color: #64748b;
    }

    .atlet-wizard-card .form-control,
    .atlet-wizard-card .form-select {
        border-radius: 10px;
        min-height: 42px;
    }

    .atlet-wizard-card textarea.form-control {
        min-height: 76px;
    }

    .atlet-wizard-card .input-group-text {
        background: #f8fafc;
        color: #64748b;
        border-radius: 10px 0 0 10px;
    }

    /* Select2 di dalam wizard */
    .atlet-wizard-card .select2-container--bootstrap-5 .select2-selection {
        min-height: 42px;
        border-radius: 10px;
        border-color: var(--neutral-300, #cbd5e1);
        display: flex;
        align-items: center;
    }

    .atlet-wizard-card .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .atlet-wizard-card .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: #86b7fe;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
    }

    .select2-invalid .select2-selection {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .12) !important;
    }

    .upload-card {
        height: 100%;
        border: 1px solid var(--neutral-200, #e5e7eb);
        border-radius: 12px;
        padding: 14px;
        background: #fff;
        transition: border-color .2s ease, background .2s ease;
    }

    .upload-card:hover {
        border-color: #bfdbfe;
    }

    .upload-card.has-file {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .upload-card.is-invalid {
        border-color: #fca5a5;
        background: #fef2f2;
    }

    .upload-card .upload-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: .85rem;
    }

    .upload-card .upload-desc {
        font-size: .72rem;
        color: #64748b;
        margin-left: 24px;
    }

    .upload-card input[type=file] {
        font-size: .78rem;
        padding: .35rem;
    }

    .upload-card input[type=file]::file-selector-button {
        background: #eff6ff;
        color: #1d4ed8;
        border: 0;
        padding: .42rem .75rem;
        margin: -.2rem .7rem -.2rem -.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: .78rem;
        cursor: pointer;
    }

    .upload-card input[type=file]::file-selector-button:hover {
        background: #dbeafe;
    }

    .upload-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        padding: 8px 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .75);
        border: 1px dashed #86efac;
    }

    .upload-preview img {
        width: 52px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        background: #fff;
    }

    .upload-preview__name {
        font-size: .74rem;
        font-weight: 600;
        color: #166534;
        word-break: break-all;
        line-height: 1.2;
    }

    .upload-preview__size {
        font-size: .7rem;
        color: #64748b;
    }

    .upload-error {
        display: none;
        margin-top: 6px;
        font-size: .72rem;
        color: #dc3545;
        font-weight: 600;
    }

    .upload-card.is-invalid .upload-error {
        display: block;
    }

    .nomor-slot {
        border: 1px solid var(--neutral-200, #e5e7eb);
        border-radius: 12px;
        padding: 12px;
        background: #f8fafc;
        height: 100%;
    }

    .nomor-slot .form-label {
        margin-bottom: .4rem !important;
    }

    .review-box {
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        padding: 16px;
        height: 100%;
    }

    .review-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: .8rem;
    }

    .review-item:last-child {
        border-bottom: 0;
    }

    .review-item .label {
        color: #64748b;
        flex: none;
    }

    .review-item .value {
        text-align: right;
        font-weight: 600;
        color: var(--text-primary-light, #0f172a);
        word-break: break-word;
    }

    .wizard-footer {
        position: sticky;
        bottom: 0;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px 20px;
        border-top: 1px solid var(--neutral-200, #e5e7eb);
        background: rgba(255, 255, 255, .96);
        backdrop-filter: blur(8px);
        border-radius: 0 0 16px 16px;
    }

    .wizard-footer .btn {
        border-radius: 10px;
        font-weight: 600;
    }

    .field-status {
        min-height: 18px;
        font-size: .74rem;
        display: block;
        margin-top: 4px;
    }

    @media (max-width: 767.98px) {
        .atlet-step {
            padding: 10px;
            gap: 8px;
        }

        .atlet-step__desc {
            display: none;
        }

        .atlet-step__title {
            font-size: .78rem;
        }

        .atlet-step__num {
            width: 28px;
            height: 28px;
            min-width: 28px;
            font-size: .75rem;
        }
    }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h5 class="fw-semibold mb-1"><?= $isEdit ? 'Ubah' : 'Tambah' ?> Data Atlet Pelajar</h5>
        <p class="text-secondary-light mb-0 text-sm">
            Lengkapi data atlet dalam 3 langkah: identitas, berkas pendukung, lalu pilih cabang olahraga.
        </p>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card atlet-wizard-card">
            <div class="card-body pb-3">
                <div class="atlet-steps mb-3" role="tablist">
                    <div id="tabStep1" class="atlet-step is-active is-clickable" data-step="1" role="tab" aria-selected="true">
                        <span class="atlet-step__num">1</span>
                        <span class="d-flex flex-column">
                            <span class="atlet-step__title">Data Atlet</span>
                            <span class="atlet-step__desc">Identitas &amp; domisili</span>
                        </span>
                    </div>
                    <div id="tabStep2" class="atlet-step is-clickable" data-step="2" role="tab" aria-selected="false">
                        <span class="atlet-step__num">2</span>
                        <span class="d-flex flex-column">
                            <span class="atlet-step__title">Lampiran</span>
                            <span class="atlet-step__desc">Berkas persyaratan</span>
                        </span>
                    </div>
                    <div id="tabStep3" class="atlet-step is-clickable" data-step="3" role="tab" aria-selected="false">
                        <span class="atlet-step__num">3</span>
                        <span class="d-flex flex-column">
                            <span class="atlet-step__title">Cabor &amp; Nomor</span>
                            <span class="atlet-step__desc">Pilih nomor lomba</span>
                        </span>
                    </div>
                </div>
                <div class="atlet-progress">
                    <div class="progress-bar" id="wizardProgress" role="progressbar" style="width: 33.33%"></div>
                </div>
            </div>

            <form id="wizardForm" action="<?= site_url('sekolah/atlet/add'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="card-body pt-4">
                    <!-- ================= STEP 1 ================= -->
                    <section id="step1" class="wizard-step">
                        <div class="wizard-section-head">
                            <span class="icon-box"><iconify-icon icon="lucide:user-round-pen"></iconify-icon></span>
                            <div>
                                <h6 class="fw-semibold mb-0">Identitas Atlet</h6>
                                <p class="text-secondary-light mb-0 text-sm">Isi data sesuai dokumen resmi (KK / Akte / NISN).</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Asal Sekolah</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <iconify-icon icon="icon-park-outline:school"></iconify-icon>
                                    </span>
                                    <input type="text" class="form-control bg-light" value="<?= esc($sekolah['nama'] ?? ''); ?>" readonly>
                                    <input type="hidden" name="sekolah" value="<?= esc($sekolah['id'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-flex justify-content-between">
                                    <span>NIK <span class="text-danger">*</span></span>
                                    <span class="text-secondary-light fw-normal">16 digit</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:id-card"></iconify-icon></span>
                                    <input type="text" id="nik" name="nik" class="form-control" inputmode="numeric"
                                        maxlength="16" minlength="16" placeholder="Nomor Induk Kependudukan"
                                        autocomplete="off" value="<?= esc($oldValue('nik', $atlet['nik'] ?? '')); ?>" required>
                                    <button type="button" class="btn btn-outline-primary" id="cekNik">Cek</button>
                                </div>
                                <small id="nikStatus" class="field-status text-secondary-light">Masukkan 16 digit NIK.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-flex justify-content-between">
                                    <span>NISN <span class="text-danger">*</span></span>
                                    <span class="text-secondary-light fw-normal">10 digit</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:badge-check"></iconify-icon></span>
                                    <input type="text" id="nisn" name="nisn" class="form-control" inputmode="numeric"
                                        minlength="10" maxlength="10" placeholder="Nomor Induk Siswa Nasional"
                                        autocomplete="off" value="<?= esc($oldValue('nisn', $atlet['nisn'] ?? '')); ?>" required>
                                    <button type="button" class="btn btn-outline-primary" id="cekNisn">Cek</button>
                                </div>
                                <small id="nisnStatus" class="field-status text-secondary-light">Masukkan 10 digit NISN.</small>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:user"></iconify-icon></span>
                                    <input type="text" id="nama" name="nama" class="form-control"
                                        placeholder="Nama lengkap sesuai KK / Akte"
                                        value="<?= esc($oldValue('nama', $atlet['nama'] ?? '')); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="jk" name="jk" data-placeholder="Pilih jenis kelamin" required>
                                    <option value=""></option>
                                    <option value="L" <?= $jkTerpilih === 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                                    <option value="P" <?= $jkTerpilih === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:map-pin"></iconify-icon></span>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control"
                                        placeholder="Kota / Kabupaten lahir"
                                        value="<?= esc($oldValue('tempat_lahir', $atlet['tempat_lahir'] ?? '')); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:calendar-days"></iconify-icon></span>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        value="<?= esc($oldValue('tanggal_lahir', $atlet['tanggal_lahir'] ?? '')); ?>" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><iconify-icon icon="lucide:home"></iconify-icon></span>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="2"
                                        placeholder="Alamat lengkap rumah (RT/RW, desa/kelurahan, kecamatan)"
                                        required><?= esc($oldValue('alamat', $atlet['alamat'] ?? '')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- ================= STEP 2 ================= -->
                    <section id="step2" class="wizard-step d-none">
                        <div class="wizard-section-head">
                            <span class="icon-box"><iconify-icon icon="lucide:paperclip"></iconify-icon></span>
                            <div>
                                <h6 class="fw-semibold mb-0">Berkas Persyaratan</h6>
                                <p class="text-secondary-light mb-0 text-sm">
                                    Format JPG, JPEG, PNG, atau WEBP dengan ukuran 100 KB &ndash; 2 MB per berkas.
                                </p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <?php foreach ($daftarBerkas as $berkas): ?>
                                <div class="col-lg-6">
                                    <div class="upload-card" data-upload-card>
                                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                            <div>
                                                <div class="upload-title">
                                                    <iconify-icon icon="<?= $berkas['icon']; ?>" width="18" height="18" class="text-primary-600"></iconify-icon>
                                                    <span><?= esc($berkas['label']); ?></span>
                                                    <?php if ($berkas['required']): ?>
                                                        <span class="text-danger">*</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="upload-desc"><?= esc($berkas['desc']); ?></div>
                                            </div>
                                            <span class="badge <?= $berkas['required'] ? 'bg-primary-50 text-primary-600' : 'bg-neutral-100 text-neutral-600'; ?> radius-8 flex-shrink-0">
                                                <?= $berkas['required'] ? 'Wajib' : 'Opsional'; ?>
                                            </span>
                                        </div>

                                        <input type="file" name="<?= $berkas['name']; ?>" class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp" <?= $berkas['required'] ? 'required' : ''; ?>>
                                        <small class="form-hint d-block mt-1">JPG, JPEG, PNG, WEBP &bull; 100 KB &ndash; 2 MB</small>
                                        <div class="upload-error"></div>

                                        <div class="upload-preview d-none">
                                            <img src="" alt="Pratinjau berkas">
                                            <div>
                                                <div class="upload-preview__name"></div>
                                                <div class="upload-preview__size"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <!-- ================= STEP 3 ================= -->
                    <section id="step3" class="wizard-step d-none">
                        <div class="wizard-section-head">
                            <span class="icon-box"><iconify-icon icon="lucide:trophy"></iconify-icon></span>
                            <div>
                                <h6 class="fw-semibold mb-0">Cabang Olahraga &amp; Nomor Lomba</h6>
                                <p class="text-secondary-light mb-0 text-sm">
                                    Pilih cabang olahraga, lalu tentukan nomor lomba yang akan diikuti.
                                </p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-7">
                                <div class="mb-3">
                                    <label class="form-label">Cabang Olahraga <span class="text-danger">*</span></label>
                                    <select name="cabor" id="cabor" class="form-select select2" data-placeholder="Pilih cabang olahraga" required>
                                        <option value=""></option>
                                        <?php foreach ($cabor as $c): ?>
                                            <option value="<?= $c['id']; ?>" <?= (old('cabor') == $c['id'] || ($atlet['cabor_id'] ?? null) == $c['id']) ? 'selected' : '' ?>>
                                                <?= esc($c['nama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label class="form-label d-flex justify-content-between">
                                    <span>Nomor Lomba <span class="text-danger">*</span></span>
                                    <span class="text-secondary-light fw-normal">Maksimal 3 nomor</span>
                                </label>
                                <div id="nomor_cabor_container" class="row g-2">
                                    <div class="col-12">
                                        <div class="nomor-slot text-center text-secondary-light py-4">
                                            <iconify-icon icon="lucide:list-checks" width="26" height="26" class="mb-1"></iconify-icon>
                                            <div class="text-sm">Pilih cabang olahraga terlebih dahulu.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-hint mt-2">
                                    <i class="ri-information-line"></i>
                                    Nomor yang sudah dipilih akan otomatis dinonaktifkan pada pilihan lainnya.
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="review-box">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <iconify-icon icon="lucide:clipboard-check" class="text-primary-600" width="18" height="18"></iconify-icon>
                                        <h6 class="fw-semibold mb-0">Ringkasan Data</h6>
                                    </div>
                                    <p class="text-secondary-light text-sm mb-2">Periksa kembali sebelum menyimpan.</p>
                                    <div id="reviewList"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori disembunyikan (kompatibilitas form lama) -->
                        <div class="d-none">
                            <select name="kategori" id="kategori">
                                <option value="" selected></option>
                                <option value="1">Usia Dini</option>
                                <option value="2">Pra Remaja</option>
                                <option value="3">Remaja</option>
                            </select>
                        </div>
                    </section>
                </div>

                <!-- ================= FOOTER NAV ================= -->
                <div class="wizard-footer">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary d-none" id="backStep1">
                            <i class="ri-arrow-left-line"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-outline-secondary d-none" id="backStep2">
                            <i class="ri-arrow-left-line"></i> Sebelumnya
                        </button>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <span class="text-secondary-light text-sm d-none d-sm-inline" id="wizardHint">Langkah 1 dari 3</span>
                        <button type="button" class="btn btn-primary-600" id="toStep2">
                            Lanjut <i class="ri-arrow-right-line"></i>
                        </button>
                        <button type="button" class="btn btn-primary-600 d-none" id="toStep3">
                            Lanjut <i class="ri-arrow-right-line"></i>
                        </button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">
                            <i class="ri-save-3-line"></i> Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';

        const form = document.getElementById('wizardForm');
        const stepEls = [1, 2, 3].map(n => document.getElementById('step' + n));
        const tabEls = [1, 2, 3].map(n => document.getElementById('tabStep' + n));
        const btnNext1 = document.getElementById('toStep2');
        const btnNext2 = document.getElementById('toStep3');
        const btnBack1 = document.getElementById('backStep1');
        const btnBack2 = document.getElementById('backStep2');
        const btnSubmit = document.getElementById('submitBtn');
        const progress = document.getElementById('wizardProgress');
        const hint = document.getElementById('wizardHint');
        const card = document.querySelector('.atlet-wizard-card');

        let current = 1;
        let maxStep = 1;
        let nikDuplicate = false;
        let nisnDuplicate = false;
        let submitting = false;

        /* ============ STEP NAVIGATION ============ */
        function renderStepper() {
            tabEls.forEach((tab, index) => {
                const step = index + 1;
                tab.classList.toggle('is-active', step === current);
                tab.classList.toggle('is-done', step < current);
                tab.setAttribute('aria-selected', step === current ? 'true' : 'false');
                tab.classList.toggle('is-clickable', step <= maxStep);
            });

            btnNext1.classList.toggle('d-none', current !== 1);
            btnNext2.classList.toggle('d-none', current !== 2);
            btnSubmit.classList.toggle('d-none', current !== 3);
            btnBack1.classList.toggle('d-none', current !== 2);
            btnBack2.classList.toggle('d-none', current !== 3);
            hint.textContent = 'Langkah ' + current + ' dari 3';
            progress.style.width = (current / 3 * 100) + '%';
        }

        function showStep(step) {
            if (step < 1 || step > 3) return;

            current = step;
            maxStep = Math.max(maxStep, step);

            stepEls.forEach((el, index) => {
                el.classList.toggle('d-none', index + 1 !== step);
            });

            renderStepper();

            if (step === 3) {
                buildReview();
            }

            if (step !== 1) {
                card.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        /* ============ VALIDATION ============ */
        function clearInvalid(field) {
            field.classList.remove('is-invalid');
            if (field.tagName === 'SELECT') {
                const container = field.nextElementSibling;
                if (container && container.classList.contains('select2-container')) {
                    container.classList.remove('select2-invalid');
                }
            }
        }

        function validateStep(step) {
            const container = stepEls[step - 1];
            const fields = container.querySelectorAll('input, select, textarea');
            let firstInvalid = null;

            fields.forEach(field => {
                if (field.disabled || field.type === 'hidden') return;

                // Abaikan field yang memang disembunyikan di dalam step
                // (jangan abaikan seluruh step saat step sedang tidak aktif).
                const hiddenParent = field.closest('.d-none');
                if (hiddenParent && hiddenParent !== container) return;

                const isValid = field.checkValidity();

                field.classList.toggle('is-invalid', !isValid);

                if (field.tagName === 'SELECT') {
                    const select2 = field.nextElementSibling;
                    if (select2 && select2.classList.contains('select2-container')) {
                        select2.classList.toggle('select2-invalid', !isValid);
                    }
                }

                if (!isValid && !firstInvalid) {
                    firstInvalid = field;
                }
            });

            if (firstInvalid) {
                firstInvalid.reportValidity();
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data belum lengkap',
                        text: 'Silakan lengkapi kolom yang ditandai merah terlebih dahulu.',
                        confirmButtonColor: '#2563eb'
                    });
                }
                return false;
            }

            if (step === 1 && (nikDuplicate || nisnDuplicate)) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data sudah terdaftar',
                        text: 'NIK atau NISN yang Anda masukkan sudah terdaftar pada atlet lain.',
                        confirmButtonColor: '#2563eb'
                    });
                }
                return false;
            }

            return true;
        }

        btnNext1.addEventListener('click', () => {
            if (validateStep(1)) showStep(2);
        });

        btnNext2.addEventListener('click', () => {
            if (validateStep(2)) showStep(3);
        });

        btnBack1.addEventListener('click', () => showStep(1));
        btnBack2.addEventListener('click', () => showStep(2));

        tabEls.forEach(tab => {
            tab.addEventListener('click', () => {
                const step = parseInt(tab.dataset.step, 10);
                if (step === current) return;
                if (step < current || step <= maxStep) {
                    showStep(step);
                }
            });
        });

        form.addEventListener('submit', function(event) {
            if (submitting) {
                event.preventDefault();
                return;
            }

            if (!validateStep(1)) {
                event.preventDefault();
                showStep(1);
                return;
            }

            if (!validateStep(2)) {
                event.preventDefault();
                showStep(2);
                return;
            }

            if (!validateStep(3)) {
                event.preventDefault();
                return;
            }

            submitting = true;
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        });

        /* Reset invalid state while typing */
        document.querySelectorAll('#wizardForm input, #wizardForm select, #wizardForm textarea').forEach(field => {
            field.addEventListener('input', () => clearInvalid(field));
            field.addEventListener('change', () => clearInvalid(field));
        });

        /* ============ FILE UPLOAD PREVIEW & VALIDATION ============ */
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        const MIN_SIZE = 100 * 1024;
        const MAX_SIZE = 2 * 1024 * 1024;

        function formatSize(bytes) {
            if (bytes >= 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            return Math.round(bytes / 1024) + ' KB';
        }

        document.querySelectorAll('[data-upload-card]').forEach(cardEl => {
            const input = cardEl.querySelector('input[type=file]');
            const preview = cardEl.querySelector('.upload-preview');
            const previewImg = preview ? preview.querySelector('img') : null;
            const nameEl = cardEl.querySelector('.upload-preview__name');
            const sizeEl = cardEl.querySelector('.upload-preview__size');
            const errorEl = cardEl.querySelector('.upload-error');

            input.addEventListener('change', function() {
                const file = this.files && this.files[0];

                this.setCustomValidity('');
                cardEl.classList.remove('is-invalid');
                cardEl.classList.toggle('has-file', !!file);

                if (errorEl) errorEl.textContent = '';

                if (!file) {
                    if (preview) preview.classList.add('d-none');
                    return;
                }

                let message = '';

                if (!allowedTypes.includes(file.type)) {
                    message = 'Format berkas harus JPG, JPEG, PNG, atau WEBP.';
                } else if (file.size < MIN_SIZE) {
                    message = 'Ukuran berkas minimal 100 KB.';
                } else if (file.size > MAX_SIZE) {
                    message = 'Ukuran berkas maksimal 2 MB.';
                }

                if (message) {
                    this.setCustomValidity(message);
                    this.classList.add('is-invalid');
                    cardEl.classList.add('is-invalid');
                    if (errorEl) errorEl.textContent = message;
                    if (preview) preview.classList.add('d-none');
                    return;
                }

                if (preview && previewImg && file.type.indexOf('image/') === 0) {
                    const reader = new FileReader();
                    reader.onload = event => {
                        previewImg.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                    if (nameEl) nameEl.textContent = file.name;
                    if (sizeEl) sizeEl.textContent = formatSize(file.size);
                    preview.classList.remove('d-none');
                }
            });
        });

        /* ============ NIK & NISN CHECK ============ */
        function debounce(func, delay) {
            let timer;
            return function() {
                const args = arguments;
                const context = this;
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function setStatus(el, type, text) {
            if (!el) return;
            const cls = type === 'success' ? 'text-success-main' :
                type === 'danger' ? 'text-danger-main' :
                type === 'warning' ? 'text-warning-main' : 'text-secondary-light';
            const icon = type === 'success' ? 'ri-checkbox-circle-line' :
                type === 'danger' ? 'ri-error-warning-line' :
                type === 'warning' ? 'ri-alert-line' : 'ri-information-line';

            el.className = 'field-status ' + cls;
            el.innerHTML = '<i class="' + icon + '"></i> ' + text;
        }

        function checkNik() {
            const input = document.getElementById('nik');
            const statusEl = document.getElementById('nikStatus');
            const nik = (input.value || '').trim();

            nikDuplicate = false;

            if (nik.length !== 16) {
                setStatus(statusEl, 'warning', 'NIK harus tepat 16 digit.');
                return;
            }

            setStatus(statusEl, 'muted', 'Memeriksa NIK...');

            $.post("<?= site_url('api/cek-nik'); ?>", {
                nik: nik
            }, function(res) {
                nikDuplicate = !!res.exists;
                if (res.exists) {
                    setStatus(statusEl, 'danger', 'NIK sudah terdaftar pada atlet lain.');
                } else {
                    setStatus(statusEl, 'success', 'NIK tersedia.');
                }
            }, 'json').fail(function() {
                setStatus(statusEl, 'warning', 'Gagal memeriksa NIK. Coba lagi.');
            });
        }

        function checkNisn() {
            const input = document.getElementById('nisn');
            const statusEl = document.getElementById('nisnStatus');
            const nisn = (input.value || '').trim();

            nisnDuplicate = false;

            if (nisn.length !== 10) {
                setStatus(statusEl, 'warning', 'NISN harus tepat 10 digit.');
                return;
            }

            setStatus(statusEl, 'muted', 'Memeriksa NISN...');

            $.post("<?= site_url('api/cek-nisn'); ?>", {
                nisn: nisn
            }, function(res) {
                nisnDuplicate = !!res.exists;
                if (res.exists) {
                    setStatus(statusEl, 'danger', 'NISN sudah terdaftar pada atlet lain.');
                } else {
                    setStatus(statusEl, 'success', 'NISN tersedia.');
                }
            }, 'json').fail(function() {
                setStatus(statusEl, 'warning', 'Gagal memeriksa NISN. Coba lagi.');
            });
        }

        const checkNikDebounced = debounce(checkNik, 600);
        const checkNisnDebounced = debounce(checkNisn, 600);

        $('#nik').on('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
            checkNikDebounced();
        });

        $('#nisn').on('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
            checkNisnDebounced();
        });

        $('#cekNik').on('click', checkNik);
        $('#cekNisn').on('click', checkNisn);

        /* ============ TANGGAL LAHIR (max hari ini) ============ */
        const tanggalLahir = document.getElementById('tanggal_lahir');
        if (tanggalLahir) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            tanggalLahir.max = yyyy + '-' + mm + '-' + dd;
        }

        /* ============ CABOR & NOMOR LOMBA ============ */
        function escapeHtml(value) {
            return String(value == null ? '' : value).replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[char]));
        }

        function nomorLabel(nomor) {
            const parts = [nomor.nama || ''];
            if (nomor.kategori) parts.push(nomor.kategori);
            if (nomor.detail) parts.push('(' + nomor.detail + ')');
            if (nomor.jenis) parts.push(nomor.jenis);
            return parts.filter(Boolean).join(' ');
        }

        function refreshNomorOptions() {
            const selected = [];

            $('.nomor-cabor-select').each(function() {
                const value = $(this).val();
                if (value) selected.push(String(value));
            });

            $('.nomor-cabor-select').each(function() {
                const select = $(this);
                const ownValue = String(select.val() || '');

                select.find('option').each(function() {
                    const optionValue = String($(this).val() || '');
                    if (!optionValue) return;
                    const usedElsewhere = selected.includes(optionValue) && optionValue !== ownValue;
                    $(this).prop('disabled', usedElsewhere);
                });

                select.trigger('change.select2');
            });
        }

        function initNomorSelects() {
            if (!$.fn.select2) return;

            $('.nomor-cabor-select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih nomor lomba',
                allowClear: true
            });
        }

        $(document).on('change', '.nomor-cabor-select', function() {
            refreshNomorOptions();
            if (current === 3) buildReview();
        });

        $('#cabor').on('change', function() {
            const caborId = $(this).val();
            const container = $('#nomor_cabor_container');

            if (!caborId) {
                container.html(`
                    <div class="col-12">
                        <div class="nomor-slot text-center text-secondary-light py-4">
                            <iconify-icon icon="lucide:list-checks" width="26" height="26" class="mb-1"></iconify-icon>
                            <div class="text-sm">Pilih cabang olahraga terlebih dahulu.</div>
                        </div>
                    </div>`);
                if (current === 3) buildReview();
                return;
            }

            container.html(`
                <div class="col-12">
                    <div class="nomor-slot text-center py-4">
                        <span class="spinner-border spinner-border-sm text-primary-600"></span>
                        <span class="ms-2 text-secondary-light text-sm">Memuat nomor lomba...</span>
                    </div>
                </div>`);

            $.ajax({
                url: "<?= site_url('api/getBanyakNomorCabor'); ?>",
                method: 'POST',
                data: {
                    cabor_id: caborId
                },
                dataType: 'json',
                success: function(limitResponse) {
                    let jumlah = parseInt(limitResponse, 10);

                    if (!jumlah || jumlah < 1) {
                        container.html(`
                            <div class="col-12">
                                <div class="nomor-slot text-center text-warning-main py-4">
                                    <iconify-icon icon="lucide:alert-circle" width="26" height="26" class="mb-1"></iconify-icon>
                                    <div class="text-sm">Cabang olahraga ini belum memiliki nomor lomba aktif.</div>
                                </div>
                            </div>`);
                        return;
                    }

                    jumlah = Math.min(jumlah, 3);

                    $.ajax({
                        url: "<?= site_url('api/getNomorCabor'); ?>",
                        method: 'POST',
                        data: {
                            cabor_id: caborId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (!response || !response.length) {
                                container.html(`
                                    <div class="col-12">
                                        <div class="nomor-slot text-center text-warning-main py-4">
                                            <iconify-icon icon="lucide:alert-circle" width="26" height="26" class="mb-1"></iconify-icon>
                                            <div class="text-sm">Nomor lomba belum tersedia untuk cabang olahraga ini.</div>
                                        </div>
                                    </div>`);
                                return;
                            }

                            let html = '';

                            for (let i = 0; i < jumlah; i++) {
                                const required = i === 0;

                                html += `
                                    <div class="col-md-6">
                                        <div class="nomor-slot">
                                            <label class="form-label d-flex justify-content-between">
                                                <span>Nomor Lomba ${i + 1} ${required ? '<span class="text-danger">*</span>' : ''}</span>
                                                <span class="badge ${required ? 'bg-primary-50 text-primary-600' : 'bg-neutral-100 text-neutral-600'} radius-8">
                                                    ${required ? 'Wajib' : 'Opsional'}
                                                </span>
                                            </label>
                                            <select name="nomor_cabor_${i + 1}" class="form-select nomor-cabor-select" ${required ? 'required' : ''}>
                                                <option value=""></option>`;

                                response.forEach(function(nomor) {
                                    html += `<option value="${escapeHtml(nomor.id)}">${escapeHtml(nomorLabel(nomor))}</option>`;
                                });

                                html += `</select></div></div>`;
                            }

                            container.html(html);
                            initNomorSelects();

                            if (typeof Iconify !== 'undefined' && Iconify.scan) {
                                Iconify.scan(container[0]);
                            }

                            if (current === 3) buildReview();
                        },
                        error: function() {
                            container.html(`
                                <div class="col-12">
                                    <div class="nomor-slot text-center text-danger-main py-4">
                                        <iconify-icon icon="lucide:wifi-off" width="26" height="26" class="mb-1"></iconify-icon>
                                        <div class="text-sm">Gagal memuat nomor lomba. Silakan coba lagi.</div>
                                    </div>
                                </div>`);
                        }
                    });
                },
                error: function() {
                    container.html(`
                        <div class="col-12">
                            <div class="nomor-slot text-center text-danger-main py-4">
                                <iconify-icon icon="lucide:wifi-off" width="26" height="26" class="mb-1"></iconify-icon>
                                <div class="text-sm">Gagal memuat data cabang olahraga. Silakan coba lagi.</div>
                            </div>
                        </div>`);
                }
            });
        });

        /* ============ REVIEW SUMMARY ============ */
        function getNomorTerpilih() {
            const labels = [];

            $('.nomor-cabor-select').each(function() {
                const value = $(this).val();
                if (!value) return;
                const text = $(this).find('option:selected').text().trim();
                if (text) labels.push(text);
            });

            return labels.length ? labels.join(', ') : '-';
        }

        function buildReview() {
            const reviewList = document.getElementById('reviewList');
            if (!reviewList) return;

            const jkText = $('#jk option:selected').text().trim() || '-';
            const caborText = $('#cabor option:selected').text().trim() || '-';
            const tempat = $('#tempat_lahir').val() || '-';
            const tanggal = $('#tanggal_lahir').val() || '-';

            let tanggalLabel = tanggal;
            if (tanggal) {
                const parsed = new Date(tanggal + 'T00:00:00');
                if (!isNaN(parsed.getTime())) {
                    tanggalLabel = parsed.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                }
            }

            let berkasTerlampir = 0;
            document.querySelectorAll('[data-upload-card] input[type=file]').forEach(input => {
                if (input.files && input.files.length) berkasTerlampir++;
            });

            const items = [
                ['Nama Lengkap', $('#nama').val() || '-'],
                ['NIK', $('#nik').val() || '-'],
                ['NISN', $('#nisn').val() || '-'],
                ['Jenis Kelamin', jkText],
                ['Tempat, Tanggal Lahir', tempat + ', ' + tanggalLabel],
                ['Cabang Olahraga', caborText],
                ['Nomor Lomba', getNomorTerpilih()],
                ['Berkas Terlampir', berkasTerlampir + ' berkas']
            ];

            reviewList.innerHTML = items.map(item => `
                <div class="review-item">
                    <span class="label">${escapeHtml(item[0])}</span>
                    <span class="value">${escapeHtml(item[1])}</span>
                </div>`).join('');
        }

        $('#jk, #nama, #nik, #nisn, #tempat_lahir, #tanggal_lahir, #alamat, #cabor').on('change input', function() {
            if (current === 3) buildReview();
        });

        /* Initialize */
        renderStepper();

        // Jika halaman dimuat ulang dengan data lama (mis. gagal validasi upload),
        // pastikan daftar nomor lomba tetap dimuat untuk cabor yang sudah dipilih.
        if ($('#cabor').val()) {
            $('#cabor').trigger('change');
        }
    })();
</script>

<?= $this->endSection(); ?>
