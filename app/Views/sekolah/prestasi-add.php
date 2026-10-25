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
    'formUrl'     => site_url('sekolah/kompetisi/prestasi-add'),
    'backUrl'     => base_url('sekolah/kompetisi/data'),
    'role'        => $role,
    'hasNomorLomba' => false,
]); ?>

<?= $this->endSection(); ?>
