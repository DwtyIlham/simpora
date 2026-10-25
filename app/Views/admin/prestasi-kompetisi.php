<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/table-prestasi', [
    'kompetisi'       => $kompetisi ?? [],
    'title'           => $title ?? 'Data Prestasi',
    'canAddPrestasi'  => $role === 'admin',
    'prestasiUrl'     => base_url('admin/kompetisi/prestasi/'),
    'addPrestasiUrl'  => base_url('admin/kompetisi/prestasi-add/'),
]); ?>

<?= $this->endSection(); ?>
