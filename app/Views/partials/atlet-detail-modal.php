<?php
/**
 * Partial: Modal Detail & Verifikasi Atlet (Shared)
 * Digunakan oleh admin, validator, dan sekolah.
 *
 * Element ID & data attribute yang dipertahankan untuk kompatibilitas JS:
 *   #viewAtletModal, #file-gallery, #v-header-*, #v-doc-progress-*,
 *   #btnValidateAll, #modalNotes, #note-text, #note-type, #save-note
 *
 * Variabel yang diharapkan dari view pemanggil:
 *   $atletDetailUrl   -> endpoint api/get_detail_atlet
 *   $validasiAtletUrl -> endpoint api/validasi-atlet
 *   $setAtletValidUrl -> endpoint api/set-atlet-valid
 *   $validasiDokumenUrl -> endpoint api/validasi-dokumen
 *   $canValidate      -> boolean (admin/validator = true, sekolah = false)
 *   $role             -> 'admin' | 'validator' | 'sekolah'
 */
?>

<link rel="stylesheet" href="<?= base_url('public/assets/css/atlet-detail.css?v=4'); ?>">
<script src="<?= base_url('public/assets/js/gallery.js?v=5'); ?>"></script>

<!-- MODAL DETAIL ATLET -->
<div class="modal fade" id="viewAtletModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content atlet-detail-modal">

            <div class="modal-header atlet-detail-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="atlet-detail-avatar">
                        <iconify-icon icon="solar:user-id-bold" width="28" height="28"></iconify-icon>
                    </div>
                    <div>
                        <div class="atlet-detail-eyebrow">Detail &amp; Verifikasi Atlet</div>
                        <h5 class="modal-title text-light mb-0" id="v-header-nama">-</h5>
                        <div class="atlet-detail-meta">
                            <span>NISN <span id="v-header-nisn">-</span></span>
                            <span class="dot"></span>
                            <span id="v-header-sekolah">-</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="v-header-status" class="badge bg-secondary text-light">Memuat...</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    <!-- DATA ATLET -->
                    <div class="col-lg-4">
                        <div class="atlet-detail-card h-100">
                            <div class="atlet-detail-card-head">Identitas Atlet</div>
                            <div class="atlet-detail-body">
                                <div class="atlet-detail-row"><span>Nama</span><strong id="v-nama">-</strong></div>
                                <div class="atlet-detail-row"><span>NISN</span><strong id="v-nisn">-</strong></div>
                                <div class="atlet-detail-row"><span>NIK</span><strong id="v-nik">-</strong></div>
                                <div class="atlet-detail-row"><span>Jenis Kelamin</span><strong id="v-jk">-</strong></div>
                                <div class="atlet-detail-row"><span>Tempat, Tanggal Lahir</span><strong id="v-ttl">-</strong></div>
                                <div class="atlet-detail-row"><span>Alamat</span><strong id="v-alamat">-</strong></div>
                            </div>

                            <div class="atlet-detail-card-head">Sekolah &amp; Lomba</div>
                            <div class="atlet-detail-body">
                                <div class="atlet-detail-row"><span>Sekolah</span><strong id="v-sekolah">-</strong></div>
                                <div class="atlet-detail-row"><span>Cabor</span><strong id="v-cabor">-</strong></div>
                                <div class="atlet-detail-row"><span>Nomor Lomba</span><strong id="v-nomor-lomba">-</strong></div>
                                <div class="atlet-detail-row"><span>Jenjang</span><strong id="v-jenjang">-</strong></div>
                            </div>

                            <div class="p-3 border-top">
                                <button type="button" class="btn btn-light w-100 d-flex align-items-center justify-content-center gap-2" data-bs-dismiss="modal">
                                    <iconify-icon icon="mingcute:square-arrow-left-line" class="text-lg"></iconify-icon> Kembali
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- FILE GALLERY -->
                    <div class="col-lg-8">
                        <div class="verify-toolbar">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-end mb-2">
                                    <div>
                                        <div class="verify-title">Checklist Berkas</div>
                                        <div class="verify-subtitle" id="v-doc-progress-text">0 dari 0 dokumen valid</div>
                                    </div>
                                    <div class="verify-percent" id="v-doc-progress-percent">0%</div>
                                </div>
                                <div class="progress verify-progress">
                                    <div id="v-doc-progress-bar" class="progress-bar bg-success" style="width:0%"></div>
                                </div>
                            </div>
                            <?php if ($canValidate ?? false): ?>
                                <button type="button" id="btnValidateAll" class="btn btn-success">
                                    <i class="ri-check-double-line me-1"></i> Validasi Semua
                                </button>
                            <?php endif; ?>
                        </div>

                        <div id="file-gallery" class="file-gallery-grid">
                            <div class="text-muted p-4">Memuat data...</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer atlet-detail-footer">
                <div class="small text-muted">
                    <i class="ri-information-line me-1"></i> Perubahan validasi langsung tersimpan.
                </div>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal Catatan (di luar modal detail agar tidak nested modal) -->
<div class="modal fade" id="modalNotes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <textarea id="note-text" class="form-control" rows="4" placeholder="Tulis catatan untuk sekolah..."></textarea>
                <input type="hidden" id="note-type">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="save-note">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfigurasi endpoint per role (di-override oleh view pemanggil jika diperlukan)
    window.ATLET_DETAIL_URL  = <?= json_encode(site_url('api/get_detail_atlet')); ?>;
    window.ATLET_VALIDASI_URL = <?= json_encode(site_url('api/validasi-atlet')); ?>;
    window.ATLET_SET_VALID_URL = <?= json_encode(site_url('api/set-atlet-valid')); ?>;
    window.ATLET_VALIDASI_DOKUMEN_URL = <?= json_encode(site_url('api/validasi-dokumen')); ?>;
    window.ATLET_VALIDASI_SEMUA_URL = <?= json_encode(site_url('api/validasi-semua')); ?>;
    window.ATLET_NOTES_GET_URL     = <?= json_encode(site_url('api/get-catatan')); ?>;
    window.ATLET_SIMPAN_CATATAN_URL = <?= json_encode(site_url('api/simpan-catatan')); ?>;
    window.ATLET_CAN_VALIDATE = <?= json_encode($canValidate ?? false); ?>;
    window.ATLET_ROLE = <?= json_encode($role ?? 'sekolah'); ?>;
</script>
