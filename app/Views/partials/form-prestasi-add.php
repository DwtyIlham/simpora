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
    .prestasi-form .form-label { font-size: 0.875rem; font-weight: 600; }
    .prestasi-form .icon-field { position: relative; }
    .prestasi-form .icon-field .icon { position: absolute; inset-block-start: 50%; inset-inline-start: 1rem; transform: translateY(-50%); display: inline-flex; align-items: center; color: var(--text-secondary-light); }
    .prestasi-form .icon-field .icon iconify-icon { font-size: 1.125rem; }
    .prestasi-form .icon-field > input,
    .prestasi-form .icon-field > select { padding-inline-start: 2.5rem; }
    .prestasi-form .select2-container--bootstrap-5 .select2-selection--single,
    .prestasi-form .select2-container--bootstrap-5 .select2-selection--multiple { min-height: 42px; border-radius: 10px; }
    .prestasi-form .select2-container .select2-selection--multiple .select2-selection__choice { border-radius: 6px; font-size: 0.8rem; margin: 2px; }
    .prestasi-form .atlet-chip { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; min-height: 42px; border: 1px solid var(--input-form-light); border-radius: 10px; padding: 0.5rem; background: var(--neutral-50); }
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($title ?? 'Form Prestasi'); ?></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <?= esc($title ?? 'Form Prestasi'); ?>
                </a>
            </li>
            <li class="fw-medium text-secondary-light">-</li>
            <li class="fw-medium">SILAGAPORA</li>
        </ul>
    </div>
    <div>
        <a href="<?= esc($backUrl); ?>" class="btn btn-sm bg-danger-focus bg-hover-danger-200 text-danger-600 radius-8">
            <i class="ri-arrow-go-back-line"></i> Kembali
        </a>
    </div>
</div>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form <?= esc($title ?? 'Prestasi'); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= esc($formUrl); ?>" method="POST" class="prestasi-form">
                    <?= csrf_field(); ?>
                    <div class="row gy-2">
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
                        <div class="col-6">
                            <label class="form-label">Pilih Sekolah</label>
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
                        <div class="col-6">
                            <label class="form-label">Pilih Cabor</label>
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
                            <div class="col-6">
                                <label class="form-label">Pilih Nomor Lomba</label>
                                <div class="icon-field">
                                    <span class="icon"><iconify-icon icon="ri:flag-2-line"></iconify-icon></span>
                                    <select class="form-select select2" name="nomor_lomba" id="nomor_lomba" data-placeholder="Pilih Nomor Lomba" required disabled>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Atlet / Peserta -->
                        <div class="col-6">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <label class="form-label mb-0">Pilih Atlet</label>
                                <?php if ($hasNomorLomba): ?>
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="selectAllAtlet">
                                        <label class="form-check-label" style="font-size: 12px; cursor:pointer;" for="selectAllAtlet">Pilih Semua</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($hasNomorLomba): ?>
                                <select class="form-select select2" multiple name="atlet_id[]" id="atlet" data-placeholder="Ketik/Pilih Atlet" required disabled>
                                    <option></option>
                                </select>
                            <?php else: ?>
                                <select class="form-select select2" name="peserta_id" id="atlet" data-placeholder="Ketik/Pilih Atlet" disabled>
                                    <option></option>
                                </select>
                            <?php endif; ?>
                        </div>

                        <!-- Prestasi -->
                        <div class="col-6">
                            <label class="form-label">Pilih Prestasi</label>
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
                        <div class="col-12 mt-12">
                            <button type="submit" class="btn btn-primary-600 w-auto"><i class="ri-save-line me-1"></i> Simpan</button>
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

        function getNomorLomba(cabor_id, sekolah_id) {
            if (!hasNomorLomba) return;
            $('#nomor_lomba').empty().append('<option>-Pilih Nomor Lomba-</option>');
            $.ajax({
                url: `<?= site_url('api/getNomorLombaSekolah/'); ?>${cabor_id}/${sekolah_id}`,
                method: 'GET',
                success: function(res) {
                    if (!res) return;
                    $('#nomor_lomba').prop('disabled', false);
                    const items = Array.isArray(res) ? res : [res];
                    items.forEach(item => {
                        $('#nomor_lomba').append(`<option value="${item.id}">${escHtml(item.nama)}</option>`);
                    });
                }
            });
        }

        function getAtletValue(cabor_id, sekolah_id, nomor_lomba_id = null) {
            const atletSelect = $('#atlet');
            atletSelect.empty().append('<option>-Pilih Atlet-</option>');
            let url = `<?= site_url('api/get-peserta-kompetisi-caborsekolah/'); ?>${cabor_id}/${sekolah_id}`;
            if (nomor_lomba_id) url += `?nomor_lomba_id=${nomor_lomba_id}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(res) {
                    const hasData = res && res.length > 0;
                    if (hasNomorLomba) {
                        $('#atlet').prop('disabled', !hasData);
                        $('#prestasi').prop('disabled', !hasData);
                    } else {
                        $('#atlet').prop('disabled', !hasData);
                        $('#prestasi').prop('disabled', !hasData);
                    }
                    if (res) {
                        res.forEach(v => {
                            atletSelect.append(`<option value="${escHtml(v.id)}">${escHtml(v.nama)}</option>`);
                        });
                    }
                }
            });
        }

        $('#cabor, #sekolah').on('change', function() {
            const cabor_id = $('#cabor').val();
            const sekolah_id = $('#sekolah').val();

            if (hasNomorLomba) {
                $('#nomor_lomba').val(null).prop('disabled', true);
                $('#atlet').val(null).prop('disabled', true);
                $('#prestasi').prop('disabled', true);
            } else {
                $('#atlet').prop('disabled', true);
                $('#prestasi').prop('disabled', true);
            }

            if (cabor_id && sekolah_id) {
                if (hasNomorLomba) {
                    getNomorLomba(cabor_id, sekolah_id);
                } else {
                    getAtletValue(cabor_id, sekolah_id);
                }
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
                    $('#atlet').prop('disabled', true);
                    $('#prestasi').prop('disabled', true);
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
            });
        }

        // Select2 init
        $('.select2').select2();

        // Validasi sisi klien sebelum submit
        $('form').on('submit', function(e) {
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
                alert(errorMessage);
            }
        });
    });

    function escHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
