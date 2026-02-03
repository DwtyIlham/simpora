<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Admin Routes
$routes->get('/', 'Admin::index');
$routes->get('/dashboard', 'Admin::dashboard');
$routes->get('admin/atlet/data', 'Admin::dataAtlet');
$routes->get('admin/atlet/add', 'Admin::addDataAtlet');
$routes->get('admin/atlet/edit/(:any)', 'Admin::editDataAtlet/$1');
$routes->post('admin/atlet/edit/(:any)', 'Admin::editDataAtlet_attempt/$1');
$routes->post('admin/atlet/add', 'Admin::addDataAtlet_attempt');
$routes->get('admin/atlet/delete/(:any)', 'Admin::deleteAtlet/$1');
$routes->get('admin/users/data', 'Admin::dataUsers');
$routes->get('admin/users/add', 'Admin::addDataUsers');
$routes->post('admin/users/add', 'Admin::addDataUsers_attempt');
$routes->post('admin/users/update', 'Admin::addDataUsers_attempt');
$routes->get('admin/users/delete/(:any)', 'Admin::deleteUser/$1');
$routes->get('admin/kompetisi/cabor', 'Admin::dataCabor');
$routes->post('admin/cabor/add', 'Admin::addCabor');
$routes->post('admin/kompetisi/editCabor', 'Admin::editCabor');
$routes->get('admin/cabor/delete/(:num)', 'Admin::deleteCabor/$1');
$routes->get('admin/kompetisi/nomor-cabor', 'Admin::dataNomorCabor');
$routes->post('admin/kompetisi/nomor-cabor/add', 'Admin::addNomorCabor');
$routes->post('admin/kompetisi/nomor-cabor/edit/(:num)', 'Admin::editNomorCabor/$1');
$routes->get('admin/ganti-password', 'Admin::ganti_password');
$routes->post('admin/ganti-password-attempt', 'Admin::ganti_password_attempt');


// Sekolah Routes
$routes->get('sekolah/dashboard', 'Sekolah::dashboard');
$routes->get('sekolah/atlet/data', 'Sekolah::dataAtlet');
$routes->get('sekolah/atlet/add', 'Sekolah::addDataAtlet');
$routes->get('sekolah/atlet/edit/(:any)', 'Sekolah::editDataAtlet/$1');
$routes->post('sekolah/atlet/edit/(:any)', 'Sekolah::editDataAtlet_attempt/$1');
$routes->post('sekolah/atlet/add', 'Sekolah::addDataAtlet_attempt');
$routes->get('sekolah/atlet/delete/(:any)', 'Sekolah::deleteAtlet/$1');
$routes->get('sekolah/users/data', 'Sekolah::dataUsers');
$routes->get('sekolah/users/add', 'Sekolah::addDataUsers');
$routes->post('sekolah/users/add', 'Sekolah::addDataUsers_attempt');
$routes->post('sekolah/users/update', 'Sekolah::addDataUsers_attempt');
$routes->get('sekolah/users/delete/(:any)', 'Sekolah::deleteUser/$1');
$routes->get('sekolah/kompetisi/data', 'Sekolah::dataKompetisi');
$routes->get('sekolah/kompetisi/add', 'Sekolah::addDataKompetisi');
$routes->post('sekolah/kompetisi/add', 'Sekolah::addDataKompetisi_attempt');
$routes->get('sekolah/kompetisi/add/(:num)', 'Sekolah::addDataKompetisi/$1');
$routes->get('sekolah/kompetisi/peserta/add-multi/(:num)', 'Sekolah::addDataPesertaMulti/$1');
$routes->post('sekolah/kompetisi/add/(:num)', 'Sekolah::addDataKompetisi_attempt/$1');
$routes->get('sekolah/kompetisi/delete/(:any)', 'Sekolah::deleteKompetisi/$1');
$routes->get('sekolah/kompetisi/peserta/(:num)', 'Sekolah::peserta/$1');
$routes->get('sekolah/kompetisi/peserta/add/(:num)', 'Sekolah::addDataPeserta/$1');
$routes->post('sekolah/addPesertaMultiCabor', 'Sekolah::addPesertaMultiCabor');
$routes->get('sekolah/kompetisi/peserta/view-idcard-kompetisi/(:num)', 'Sekolah::view_idcard_peserta/$1');
$routes->post('sekolah/kompetisi/peserta/add', 'Sekolah::addDataPeserta_attempt');
$routes->get('sekolah/kompetisi/peserta/delete/(:any)/(:num)', 'Sekolah::deletePeserta/$1/$2');
$routes->get('sekolah/kompetisi/prestasi', 'Sekolah::dataKompetisiPrestasi');
$routes->get('sekolah/kompetisi/prestasi/(:any)', 'Sekolah::dataKompetisiPrestasiPeserta/$1');
$routes->get('sekolah/kompetisi/prestasi-add/(:any)', 'Sekolah::addDataPrestasi/$1');
$routes->post('sekolah/kompetisi/prestasi-add', 'Sekolah::addDataPrestasi_attempt');
$routes->post('sekolah/kompetisi/prestasi-edit', 'Sekolah::editPrestasi_attempt');
$routes->get('sekolah/view-piagam/(:any)', 'Sekolah::view_piagam/$1');

// Kompetisi routes
$routes->get('admin/kompetisi/data', 'Admin::dataKompetisi');
$routes->get('admin/kompetisi/add', 'Admin::addDataKompetisi');
$routes->post('admin/kompetisi/add', 'Admin::addDataKompetisi_attempt');
$routes->get('admin/kompetisi/add/(:num)', 'Admin::addDataKompetisi/$1');
$routes->post('admin/kompetisi/add/(:num)', 'Admin::addDataKompetisi_attempt/$1');
$routes->get('admin/kompetisi/delete/(:any)', 'Admin::deleteKompetisi/$1');
$routes->get('admin/kompetisi/peserta/(:num)', 'Admin::peserta/$1');
$routes->get('admin/kompetisi/peserta/add/(:num)', 'Admin::addDataPeserta/$1');
$routes->get('admin/kompetisi/peserta/view-idcard-kompetisi/(:num)', 'Admin::view_idcard_peserta/$1');
$routes->post('admin/kompetisi/peserta/add-multi', 'Admin::addDataPesertaMulti_attempt');
$routes->get('admin/kompetisi/peserta/delete/(:any)/(:num)', 'Admin::deletePeserta/$1/$2');
$routes->get('admin/kompetisi/prestasi', 'Admin::dataKompetisiPrestasi');
$routes->get('admin/kompetisi/prestasi/(:any)', 'Admin::dataKompetisiPrestasiPeserta/$1');
$routes->get('admin/kompetisi/prestasi-add/(:any)', 'Admin::addDataPrestasi/$1');
$routes->post('admin/kompetisi/prestasi-add', 'Admin::addDataPrestasi_attempt');
$routes->post('admin/kompetisi/prestasi-edit', 'Admin::editPrestasi_attempt');
$routes->get('admin/view-piagam/(:any)', 'Admin::view_piagam/$1');
$routes->get('pdf/view-piagam/(:any)', 'PdfController::generate_pdf/$1');

// Prestasi
$routes->get('jurnal-medali', 'Admin::jurnal_medali');
$routes->get('jurnal-medali-kab/(:segment)', 'Admin::jurnal_medali_kab/$1');
$routes->get('export/jurnal-medali-excel', 'Export::jurnalMedaliExcel');

// Operator Routes
$routes->get('api', 'Admin::api');
$routes->get('admin/operator/data', 'Admin::dataOperator');
$routes->get('admin/operator/add', 'Admin::addOperator');
$routes->post('admin/operator/add', 'Admin::addOperator_attempt');
$routes->get('admin/operator/delete/(:segment)', 'Admin::deleteOperator/$1');

// API Routes
$routes->get('api/get-data-atlet-kab', 'Api::getDataAtletKab');
$routes->get('api/get_detail_atlet', 'Api::getDetailAtlet');
$routes->get('api/validasi-dokumen', 'Api::validasi_dokumen');
$routes->get('api/validasi-atlet', 'Api::validasi_atlet');
$routes->post('api/set-atlet-valid', 'Api::set_atlet_valid');
$routes->post('api/init_atlet_validasi', 'Api::init_atlet_validasi');
$routes->post('api/simpan-catatan', 'Api::simpan_catatan');
$routes->post('api/get-catatan', 'Api::get_catatan');
$routes->post('api/getDataPesertaIDCard', 'Api::getDataPesertaIDCard');
$routes->get('api/get-peserta-kompetisi-caborsekolah/(:any)', 'Api::getPesertaKompetisiCaborSekolah/$1/$2');
$routes->post('api/get-status-user', 'Api::get_status_user');
$routes->post('api/toggle-status-user', 'Api::toggle_status_user');
$routes->post('api/toggle-nomor-cabor-status', 'Api::toggle_status_nocabor');
$routes->post('api/getNomorCabor', 'Api::getNomorCabor');
$routes->post('api/jurnal-medali-kab', 'Api::jurnal_medali_kab');
$routes->post('api/cek-regis-atlet-multi-cabor', 'Api::cekRegAtletMultiCabor');

// Validasi QR Code Routes
$routes->get('api/validasi/qr-code-atlet/(:segment)', 'Admin::validasi_peserta/$1');


// Authentication Routes
$routes->post('auth/login', 'Auth::login');
$routes->post('auth/register-attempt', 'Auth::register_attempt');
$routes->get('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');
