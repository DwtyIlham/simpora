<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/table-kompetisi', [
    'kompetisi'      => $kompetisi ?? [],
    'title'          => $title ?? 'Data Kompetisi',
    'canAdd'         => false,
    'canEdit'        => false,
    'canDelete'      => false,
    'canViewPeserta' => true,
    'addUrl'         => base_url('validator/kompetisi/add'),
    'editUrl'        => base_url('validator/kompetisi/edit/'),
    'deleteUrl'      => base_url('validator/kompetisi/delete/'),
    'pesertaUrl'     => base_url('validator/kompetisi/peserta/'),
    'role'           => $role,
]); ?>

<?= $this->endSection(); ?>
