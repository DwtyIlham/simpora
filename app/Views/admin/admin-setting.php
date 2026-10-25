<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?= $this->include('partials/admin-setting', [
    'title' => $title ?? 'Setting Sistem',
    'setting' => $setting ?? [],
    'toggleUrl' => site_url('api/toggle_admin_setting'),
]); ?>

<?= $this->endSection(); ?>
