<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/page-header', [
    'pageTitle' => 'Data Pengguna',
    'breadcrumb' => [
        ['label' => 'Dashboard', 'href' => base_url('sekolah/dashboard'), 'icon' => 'solar:home-smile-angle-outline'],
        ['label' => 'Data Pengguna', 'href' => null, 'icon' => 'solar:user-linear'],
    ],
    'actions' => [
        ['label' => 'Tambah Pengguna', 'href' => base_url('sekolah/users/add'), 'class' => 'btn btn-primary-600 radius-8', 'icon' => 'add-box-line'],
    ],
]); ?>

<?= $this->include('partials/table-users', [
    'users'        => $users ?? [],
    'canAdd'       => true,
    'canEdit'      => true,
    'canDelete'    => true,
    'canToggle'    => false,
    'addUrl'       => base_url('sekolah/users/add'),
    'updateUrl'    => site_url('sekolah/users/update'),
    'deleteUrl'    => base_url('sekolah/users/delete/'),
    'toggleStatusUrl' => site_url('api/toggle-status-user'),
    'getStatusUrl'    => site_url('api/get-status-user'),
    'showSekolah'  => false,
    'showWhatsapp' => false,
    'roleOptions'  => [
        '2' => 'Operator Sekolah',
    ],
]); ?>

<?= $this->endSection(); ?>
