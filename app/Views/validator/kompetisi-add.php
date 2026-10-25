<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
$isEdit   = !empty($kompetisi);
$formUrl  = $isEdit ? site_url('validator/kompetisi/edit/' . ($kompetisi['id'] ?? '')) : site_url('validator/kompetisi/add');
$backUrl  = base_url('validator/kompetisi/data');
?>

<?= $this->include('partials/form-kompetisi', [
    'title'   => $isEdit ? 'Edit Kompetisi' : 'Tambah Kompetisi',
    'kompetisi' => $kompetisi ?? null,
    'formUrl' => $formUrl,
    'backUrl' => $backUrl,
]); ?>

<?= $this->endSection(); ?>
