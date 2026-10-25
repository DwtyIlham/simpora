<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/page-header', [
    'pageTitle' => 'Data Pengguna',
    'breadcrumb' => [
        ['label' => 'Dashboard', 'href' => base_url($role === 'admin' ? '/dashboard' : $role . '/dashboard'), 'icon' => 'solar:home-smile-angle-outline'],
        ['label' => 'Data Pengguna', 'href' => null, 'icon' => 'solar:user-linear'],
    ],
    'actions' => [
        ['label' => 'Tambah Pengguna', 'href' => base_url('admin/users/add'), 'class' => 'btn btn-primary-600 radius-8', 'icon' => 'add-box-line'],
    ],
]); ?>

<?= $this->include('partials/table-users', [
    'users'        => $users ?? [],
    'canAdd'       => true,
    'canEdit'      => true,
    'canDelete'    => true,
    'canToggle'    => $role === 'admin',
    'addUrl'       => base_url('admin/users/add'),
    'updateUrl'    => site_url('admin/users/update'),
    'deleteUrl'    => base_url('admin/users/delete/'),
    'toggleStatusUrl' => site_url('api/toggle-status-user'),
    'getStatusUrl'    => site_url('api/get-status-user'),
    'showSekolah'  => true,
    'showWhatsapp' => true,
    'roleOptions'  => [
        '1' => 'Administrator Dinas',
        '2' => 'Operator Sekolah',
        '4' => 'Validator Dinas',
    ],
]); ?>

<?= $this->endSection(); ?>
