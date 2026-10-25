<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/table-prestasi', [
    'kompetisi'       => $kompetisi ?? [],
    'title'           => $title ?? 'Data Prestasi',
    'canAddPrestasi'  => false,
    'prestasiUrl'     => base_url('validator/kompetisi/prestasi/'),
    'addPrestasiUrl'  => base_url('validator/kompetisi/prestasi-add/'),
]); ?>

<?= $this->endSection(); ?>
