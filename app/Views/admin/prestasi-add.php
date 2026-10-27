<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/form-prestasi-add', [
    'title'       => $title ?? 'Tambah Prestasi',
    'kompetisi'   => $kompetisi ?? '',
    'id_kompetisi'=> $id_kompetisi ?? '',
    'sekolah'     => $sekolah ?? [],
    'cabor'       => $cabor ?? [],
    'formUrl'     => site_url('admin/kompetisi/prestasi-add'),
    'backUrl'     => base_url('admin/kompetisi/prestasi/' . \App\Controllers\encode_id($id_kompetisi ?? '')),
    'role'        => $role,
    'hasNomorLomba' => true,
]); ?>

<?= $this->endSection(); ?>
