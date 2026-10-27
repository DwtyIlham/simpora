<?php
/**
 * Partial: Tombol Kembali Global
 *
 * Tombol ini memakai riwayat browser bila tersedia (termasuk URL dengan
 * parameter), lalu otomatis memakai $backUrl sebagai cadangan ketika halaman
 * dibuka langsung dari tautan/baru tanpa riwayat.
 *
 * Variabel yang diharapkan:
 *   $backUrl -> URL cadangan (halaman daftar/menu induk)
 */

$backUrl = $backUrl ?? base_url('/');
?>
<a href="<?= esc($backUrl); ?>"
    class="app-back-btn"
    data-app-back
    data-fallback="<?= esc($backUrl); ?>"
    aria-label="Kembali ke halaman sebelumnya"
    title="Kembali ke halaman sebelumnya">
    <iconify-icon icon="solar:arrow-left-outline" aria-hidden="true"></iconify-icon>
    <span>Kembali</span>
</a>
