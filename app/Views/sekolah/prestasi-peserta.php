<?php

use function App\Controllers\encode_id;

?>
<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php
$roleId   = (string) (session('user')['role_id'] ?? '');
$role     = $roleId === '1' ? 'admin' : ($roleId === '4' ? 'validator' : 'sekolah');
?>

<?= $this->include('partials/table-prestasi-peserta', [
    'title'      => $title ?? 'Data Prestasi Peserta',
    'id_kompetisi'=> $id_kompetisi ?? '',
    'peserta'    => $peserta ?? [],
    'cabor'      => $cabor ?? [],
    'sekolah'    => $sekolah ?? [],
    'role'       => $role,
    'canAdd'     => false,
    'canEdit'    => false,
    'canDelete'  => false,
    'canBatch'   => false,
    'addUrl'     => base_url('sekolah/kompetisi/prestasi-add/' . ($id_kompetisi ? encode_id($id_kompetisi) : '')),
    'deleteUrl'  => base_url('sekolah/kompetisi/peserta/delete/'),
    'batchUrl'   => base_url('admin/piagam-batch/'),
]); ?>

<?= $this->endSection(); ?>
