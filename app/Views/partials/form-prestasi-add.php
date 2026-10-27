<?php
/**
 * Partial: Form Prestasi Add (Shared)
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Variabel yang diharapkan:
 *   $title      -> Judul halaman
 *   $kompetisi  -> Nama kompetisi (string, readonly)
 *   $id_kompetisi -> ID kompetisi (hidden input)
 *   $sekolah    -> Array data sekolah
 *   $cabor      -> Array data cabor
 *   $formUrl    -> URL action form (POST)
 *   $backUrl    -> URL kembali ke daftar
 *   $role       -> 'admin' | 'validator' | 'sekolah'
 *   $hasNomorLomba -> boolean (admin memiliki field nomor_lomba + atlet multi-select)
 */

use function App\Controllers\format_tgl;

$role       = $role ?? 'admin';
$hasNomorLomba = $hasNomorLomba ?? ($role === 'admin');
$formUrl    = $formUrl ?? site_url('admin/kompetisi/prestasi-add');
$backUrl    = $backUrl ?? base_url($role . '/kompetisi/data');
?>
<style>
    .prestasi-form .form-label { font-size: 0.875rem; font-weight: 600; margin-bottom: .5rem; }
    .prestasi-form .form-control, .prestasi-form .form-select { min-height: 44px; border-radius: 10px; }
    .prestasi-form .icon-field { position: relative; }
    .prestasi-form .icon-field .icon { position: absolute; inset-block-start: 50%; inset-inline-start: 1rem; transform: translateY(-50%); display: inline-flex; align-items: center; color: var(--text-secondary-light); }
    .prestasi-form .icon-field .icon iconify-icon { font-size: 1.125rem; }
    .prestasi-form .icon-field > input,
    .prestasi-form .icon-field > select { padding-inline-start: 2.5rem; }
    .prestasi-form .select2-container--bootstrap-5 .select2-selection--single,
    .prestasi-form .select2-container--bootstrap-5 .select2-selection--multiple { min-height: 42px; border-radius: 10px; }
    .prestasi-form .select2-container .select2-selection--multiple .select2-selection__choice { border-radius: 6px; font-size: 0.8rem; margin: 2px; }
    .prestasi-form .atlet-chip { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; min-height: 42px; border: 1px solid var(--input-form-light); border-radius: 10px; padding: 0.5rem; background: var(--neutral-50); }
    .prestasi-form-card { border: 1px solid #e8edf5; border-radius: 14px; box-shadow: 0 8px 24px rgba(15, 23, 42, .045); }
    .prestasi-form-card .card-header { padding: 1.25rem 1.5rem; background: transparent; }
    .prestasi-form-card .card-body { padding: 1.5rem; }
    .prestasi-form-intro { display: flex; align-items: flex-start; gap: .75rem; color: #64748b; }
    .prestasi-form-intro iconify-icon { color: #2563eb; font-size: 1.4rem; margin-top: .15rem; }
    .prestasi-form-help { display: block; margin-top: .4rem; color: #64748b; font-size: .8rem; }
    .prestasi-form .field-status { min-height: 1.25rem; margin-top: .35rem; color: #64748b; font-size: .8rem; }
    .prestasi-form-actions { position: sticky; bottom: 0; z-index: 2; display: flex; justify-content: flex-end; gap: .75rem; padding: 1rem 0 .25rem; background: rgba(255,255,255,.96); border-top: 1px solid #e8edf5; }
    .prestasi-form .select2-container--bootstrap-5 .select2-selection { min-height: 44px; }
    .prestasi-form .select2-container--disabled .select2-selection { background-color: #f8fafc; opacity: .8; }
    .prestasi-form-actions .btn:focus-visible { outline: 3px solid rgba(37, 99, 235, .3); outline-offset: 2px; }
    @media (max-width: 767.98px) {
        .prestasi-form-card .card-header, .prestasi-form-card .card-body { padding: 1rem; }
        .prestasi-form .form-field { width: 100%; }
        .prestasi-form-actions .btn { flex: 1; }
    }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Form Prestasi'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="<?= esc($backUrl); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Form Prestasi'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card prestasi-form-card">
            <div class="card-header">
                <div class="prestasi-form-intro">
                    <iconify-icon icon="solar:medal-ribbons-star-outline"></iconify-icon>
                    <div>
                        <h5 class="card-title mb-1">Form <?= esc($title ?? 'Prestasi'); ?></h5>
                        <small>Lengkapi data berikut. Pilihan atlet akan tersedia setelah sekolah, cabang, dan nomor lomba dipilih.</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= esc($formUrl); ?>" method="POST" class="prestasi-form">
                    <?= csrf_field(); ?>
                    <div class="row g-3">
                        <!-- Nama Kompetisi -->
                        <div class="col-12">
                            <label class="form-label">Nama Kompetisi</label>
                            <div class="icon-field">
                                <span class="icon"><iconify-icon icon="carbon:event"></iconify-icon></span>
                                <input type="text" class="form-control" value="<?= esc($kompetisi ?? ''); ?>" autocomplete="off" readonly>
                                <input type="hidden" name="kompetisi_id" value="<?= esc(set_value('kompetisi', $id_kompetisi ?? '')); ?>" readonly>
                            </div>
                        </div>

                        <!-- Sekolah -->
                        <div class="col-md-6 form-field">
                            <label class="form-label" for="sekolah">Pilih Sekolah <span class="text-danger">*</span></label>
                            <div class="icon-field">
                                <span class="icon"><iconify-icon icon="icon-park-outline:school"></iconify-icon></span>
                                <select class="form-select select2" name="sekolah_id" id="sekolah" data-placeholder="Pilih Sekolah" required>
                                    <option></option>
                                    <?php foreach ($sekolah ?? [] as $s): ?>
                                        <option value="<?= esc($s['id']); ?>"><?= esc($s['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Cabor -->
                        <div class="col-md-6 form-field">
                            <label class="form-label" for="cabor">Cabang Olahraga <span class="text-danger">*</span></label>
                            <div class="icon-field">
                                <span class="icon"><iconify-icon icon="fluent:sport-24-regular"></iconify-icon></span>
                                <select class="form-select select2" name="cabor" id="cabor" data-placeholder="Pilih Cabor" required>
                                    <option></option>
                                    <?php foreach ($cabor ?? [] as $c): ?>
                                        <option value="<?= esc($c['id']); ?>"><?= esc($c['nama']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Nomor Lomba (hanya admin) -->
                        <?php if ($hasNomorLomba): ?>
                            <div class="col-md-6 form-field">
                                <label class="form-label" for="nomor_lomba">Nomor Lomba <span class="text-danger">*</span></label>
                                <div class="icon-field">
                                    <span class="icon"><iconify-icon icon="ri:flag-2-line"></iconify-icon></span>
                                    <select class="form-select select2" name="nomor_lomba" id="nomor_lomba" data-placeholder="Pilih cabor dan sekolah terlebih dahulu" required disabled>
                                        <option></option>
                                    </select>
                                </div>
                                <small class="prestasi-form-help">Nomor lomba mengikuti cabor dan sekolah yang dipilih.</small>
                            </div>
                        <?php endif; ?>

                        <!-- Atlet / Peserta -->
                        <div class="col-md-6 form-field">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0" for="atlet">Pilih Atlet <span class="text-danger">*</span></label>
                                <?php if ($hasNomorLomba): ?>
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="selectAllAtlet">
                                        <label class="form-check-label" style="font-size: 12px; cursor:pointer;" for="selectAllAtlet">Pilih Semua</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($hasNomorLomba): ?>
                                <select class="form-select select2" multiple name="atlet_id[]" id="atlet" data-placeholder="Pilih nomor lomba terlebih dahulu" required disabled>
                                    <option></option>
                                </select>
                                <div class="field-status" id="atletStatus" aria-live="polite">Pilih sekolah, cabor, dan nomor lomba untuk memuat atlet.</div>
                            <?php else: ?>
                                <select class="form-select select2" name="peserta_id" id="atlet" data-placeholder="Pilih sekolah dan cabor terlebih dahulu" disabled>
                                    <option></option>
                                </select>
                                <div class="field-status" id="atletStatus" aria-live="polite">Pilih sekolah dan cabor untuk memuat atlet.</div>
                            <?php endif; ?>
                        </div>

                        <!-- Prestasi -->
                        <div class="col-md-6 form-field">
                            <label class="form-label" for="prestasi">Medali / Prestasi <span class="text-danger">*</span></label>
                            <div class="icon-field">
                                <span class="icon"><iconify-icon icon="lucide:medal"></iconify-icon></span>
                                <select class="form-select" name="prestasi_id" id="prestasi" required disabled>
                                    <option selected disabled>- Pilih Prestasi-</option>
                                    <option value="1">Emas</option>
                                    <option value="2">Perak</option>
                                    <option value="3">Perunggu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-12 mt-3">
                            <div class="prestasi-form-actions">
                                <a href="<?= esc($backUrl); ?>" class="btn btn-light">Batal</a>
                                <button type="submit" id="btnSimpanPrestasi" class="btn btn-primary-600"><i class="ri-save-line me-1"></i> Simpan Prestasi</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        const hasNomorLomba = <?= json_encode($hasNomorLomba); ?>;

        let nomorRequest = null;
        let atletRequest = null;

        function getNomorLomba(cabor_id, sekolah_id) {
            if (!hasNomorLomba) return;
            const $nomor = $('#nomor_lomba');
            if (nomorRequest) nomorRequest.abort();
            if (atletRequest) atletRequest.abort();
            $('#atlet').val(null).prop('disabled', true).empty().append('<option></option>').trigger('change');
            $('#prestasi').val('').prop('disabled', true);
            $('#selectAllAtlet').prop('checked', false);
            $nomor.prop('disabled', true).html('<option value="">Memuat nomor lomba...</option>').trigger('change.select2');
            nomorRequest = $.ajax({
                url: `<?= site_url('api/getNomorLombaSekolah/'); ?>${encodeURIComponent(cabor_id)}/${encodeURIComponent(sekolah_id)}`,
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    const items = Array.isArray(res) ? res : (res ? [res] : []);
                    $nomor.empty().append('<option value="">Pilih Nomor Lomba</option>');
                    items.forEach(function(item) {
                        $('<option>').val(item.id).text(item.nama).appendTo($nomor);
                    });
                    $nomor.prop('disabled', items.length === 0).trigger('change.select2');
                    if (items.length === 0) {
                        $('#atletStatus').text('Tidak ada nomor lomba untuk kombinasi cabor dan sekolah ini.');
                    } else {
                        $('#atletStatus').text('Pilih nomor lomba untuk memuat atlet.');
                    }
                },
                error: function(xhr, status) {
                    if (status === 'abort') return;
                    $nomor.html('<option value="">Gagal memuat nomor lomba</option>').prop('disabled', true);
                    $('#atletStatus').text('Gagal memuat data. Silakan pilih kembali cabor atau sekolah.');
                    Swal.fire({ icon: 'error', title: 'Gagal memuat nomor lomba', text: 'Silakan coba lagi.' });
                }
            });
        }

        function setAtletStatus(message) {
            $('#atletStatus').text(message);
        }

        function getAtletValue(cabor_id, sekolah_id, nomor_lomba_id = null) {
            const $atlet = $('#atlet');
            $atlet.prop('disabled', true).empty().append('<option value="">Memuat daftar atlet...</option>');
            $('#prestasi').prop('disabled', true);
            $('#selectAllAtlet').prop('checked', false);
            setAtletStatus('Sedang memuat daftar atlet...');

            let url = `<?= site_url('api/get-peserta-kompetisi-caborsekolah/'); ?>${encodeURIComponent(cabor_id)}/${encodeURIComponent(sekolah_id)}`;
            if (nomor_lomba_id) url += `?nomor_lomba_id=${encodeURIComponent(nomor_lomba_id)}`;
            if (atletRequest) atletRequest.abort();

            atletRequest = $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    const items = Array.isArray(res) ? res : [];
                    $atlet.empty().append('<option value="">Pilih atlet</option>');
                    items.forEach(function(item) {
                        $('<option>').val(item.id).text(item.nama).appendTo($atlet);
                    });
                    const hasData = items.length > 0;
                    $atlet.prop('disabled', !hasData);
                    $('#prestasi').prop('disabled', !hasData);
                    setAtletStatus(hasData ? `${items.length} atlet tersedia. Ketik nama untuk mencari.` : 'Tidak ada atlet yang sesuai dengan pilihan ini.');
                },
                error: function(xhr, status) {
                    if (status === 'abort') return;
                    $atlet.empty().append('<option value="">Data atlet gagal dimuat</option>').prop('disabled', true);
                    setAtletStatus('Gagal memuat atlet. Periksa koneksi lalu pilih ulang cabor atau sekolah.');
                    Swal.fire({ icon: 'error', title: 'Gagal memuat atlet', text: 'Silakan coba pilih ulang sekolah, cabor, atau nomor lomba.' });
                }
            });
        }

        $('#cabor, #sekolah').on('change', function() {
            const cabor_id = $('#cabor').val();
            const sekolah_id = $('#sekolah').val();
            if (nomorRequest) nomorRequest.abort();
            if (atletRequest) atletRequest.abort();
            $('#atlet').val(null).prop('disabled', true).empty().append('<option></option>').trigger('change.select2');
            $('#prestasi').val('').prop('disabled', true);
            $('#selectAllAtlet').prop('checked', false);
            setAtletStatus(hasNomorLomba ? 'Pilih sekolah, cabor, dan nomor lomba untuk memuat atlet.' : 'Pilih sekolah dan cabor untuk memuat atlet.');

            if (cabor_id && sekolah_id) {
                if (hasNomorLomba) {
                    getNomorLomba(cabor_id, sekolah_id);
                } else {
                    getAtletValue(cabor_id, sekolah_id);
                }
            } else if (hasNomorLomba) {
                $('#nomor_lomba').html('<option value="">Pilih cabor dan sekolah terlebih dahulu</option>').prop('disabled', true);
            }
        });

        // Admin: saat nomor_lomba berubah, muat atlet
        if (hasNomorLomba) {
            $('#nomor_lomba').on('change', function() {
                const nomor_lomba = $(this).val();
                const sekolah_id = $('#sekolah').val();
                if (nomor_lomba) {
                    getAtletValue($('#cabor').val(), sekolah_id, nomor_lomba);
                } else {
                    if (atletRequest) atletRequest.abort();
                    $('#atlet').val(null).prop('disabled', true).empty().append('<option></option>').trigger('change.select2');
                    $('#prestasi').val('').prop('disabled', true);
                    $('#selectAllAtlet').prop('checked', false);
                    setAtletStatus('Pilih nomor lomba untuk memuat atlet.');
                }
            });

            // Pilih Semua atlet (admin)
            $('#selectAllAtlet').on('change', function() {
                if ($(this).is(':checked')) {
                    const allValues = [];
                    $('#atlet option').each(function() {
                        const val = $(this).val();
                        if (val && val !== '-Pilih Atlet-') allValues.push(val);
                    });
                    $('#atlet').val(allValues).trigger('change');
                } else {
                    $('#atlet').val(null).trigger('change');
                }
            });
            $('#atlet').on('select2:unselect', function() {
                $('#selectAllAtlet').prop('checked', false);
            }).on('change', function() {
                const total = $('#atlet option').filter(function() { return Boolean(this.value); }).length;
                const selected = ($(this).val() || []).length;
                $('#selectAllAtlet').prop('checked', total > 0 && total === selected);
            });
        }

        // Select2 hanya untuk elemen di form ini, dengan placeholder dan pencarian yang konsisten.
        $('.prestasi-form .select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: function() { return $(this).data('placeholder') || ''; },
            allowClear: true,
            closeOnSelect: true
        });
        // Validasi sisi klien sebelum submit
        $('.prestasi-form').on('submit', function(e) {
            let isValid = true;
            let errorMessage = 'Harap lengkapi data berikut sebelum menyimpan:\n\n';

            if (!$('#sekolah').val()) {
                isValid = false;
                errorMessage += '- Sekolah belum dipilih\n';
            }
            if (!$('#cabor').val()) {
                isValid = false;
                errorMessage += '- Cabang Olahraga belum dipilih\n';
            }
            if (hasNomorLomba && (!$('#nomor_lomba').val() || $('#nomor_lomba').val() === '-Pilih Nomor Lomba-')) {
                isValid = false;
                errorMessage += '- Nomor Lomba belum dipilih\n';
            }

            const atletVal = $('#atlet').val();
            if (!atletVal || atletVal.length === 0) {
                isValid = false;
                errorMessage += '- Atlet belum dipilih (minimal 1)\n';
            }
            if (!$('#prestasi').val()) {
                isValid = false;
                errorMessage += '- Prestasi belum dipilih\n';
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: 'Data belum lengkap', text: errorMessage.replace(/\n/g, ' ') });
                return;
            }
            const $submit = $('#btnSimpanPrestasi');
            $submit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Menyimpan...');
        });
    });

    function escHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
