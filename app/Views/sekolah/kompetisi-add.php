<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
$isEdit   = !empty($kompetisi);
$formUrl  = $isEdit ? base_url('sekolah/kompetisi/add/' . ($kompetisi['id'] ?? '')) : base_url('sekolah/kompetisi/add');
$backUrl  = base_url('sekolah/kompetisi/data');
?>

<?= $this->include('partials/form-kompetisi', [
    'title'   => $isEdit ? 'Edit Kompetisi' : 'Tambah Kompetisi',
    'kompetisi' => $kompetisi ?? null,
    'formUrl' => $formUrl,
    'backUrl' => $backUrl,
]); ?>

<?= $this->endSection(); ?>
