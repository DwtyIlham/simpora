<?php
/**
 * Partial: Page Header Standar
 * Digunakan untuk semua halaman Tahap 2 (Users, Kompetisi, Prestasi, Laporan, Setting)
 *
 * Variabel yang diharapkan:
 *   $pageTitle   -> Judul halaman (string)
 *   $breadcrumb  -> Array breadcrumb [['label'=>'...', 'href'=>'...'], ...]
 *   $actions     -> Array aksi tambahan [['label'=>'...', 'href'=>'...', 'class'=>'...', 'icon'=>'...'], ...]
 */
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div>
        <h6 class="fw-semibold mb-0"><?= esc($pageTitle ?? 'Halaman'); ?></h6>
        <?php if (!empty($breadcrumb)): ?>
            <ul class="d-flex align-items-center gap-2">
                <?php foreach ($breadcrumb as $i => $b): ?>
                    <?php if ($i > 0): ?>
                        <li class="fw-medium text-secondary-light">-</li>
                    <?php endif; ?>
                    <li class="fw-medium">
                        <?php if (!empty($b['href']) && $i < count($breadcrumb) - 1): ?>
                            <a href="<?= esc($b['href']); ?>" class="d-flex align-items-center gap-1 hover-text-primary text-decoration-none">
                                <iconify-icon icon="<?= esc($b['icon'] ?? 'solar:arrow-right-linear'); ?>" class="icon text-lg"></iconify-icon>
                                <?= esc($b['label']); ?>
                            </a>
                        <?php else: ?>
                            <span class="d-flex align-items-center gap-1">
                                <iconify-icon icon="<?= esc($b['icon'] ?? 'solar:home-smile-angle-outline'); ?>" class="icon text-lg"></iconify-icon>
                                <?= esc($b['label']); ?>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="d-flex align-items-center gap-2">
        <?php if (!empty($actions)): ?>
            <?php foreach ($actions as $action): ?>
                <a href="<?= esc($action['href'] ?? '#'); ?>"
                    class="btn btn-sm <?= esc($action['class'] ?? 'bg-primary-50 text-primary-600 radius-8'); ?>"
                    <?= !empty($action['disabled']) ? 'disabled' : ''; ?>
                    <?= !empty($action['onclick']) ? 'onclick="' . esc($action['onclick']) . '"' : ''; ?>>
                    <i class="ri-<?= esc($action['icon'] ?? 'add-box-line'); ?>"></i> <?= esc($action['label']); ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
