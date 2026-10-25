<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/table-kompetisi', [
    'kompetisi'      => $kompetisi ?? [],
    'title'          => $title ?? 'Data Kompetisi',
    'canAdd'         => $role === 'admin',
    'canEdit'        => $role === 'admin',
    'canDelete'      => $role === 'admin',
    'canViewPeserta' => true,
    'addUrl'         => base_url('admin/kompetisi/add'),
    'editUrl'        => base_url('admin/kompetisi/edit/'),
    'deleteUrl'      => base_url('admin/kompetisi/delete/'),
    'pesertaUrl'     => base_url($role . '/kompetisi/peserta/'),
    'role'           => $role,
]); ?>

<?= $this->endSection(); ?>
