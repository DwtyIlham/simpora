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
$routes->get('admin/validator/data', 'Admin::dataValidators');
$routes->post('admin/users/add', 'Admin::addDataUsers_attempt');
$routes->post('admin/users/addValidator', 'Admin::addValidator');
$routes->post('admin/users/update', 'Admin::addDataUsers_attempt');
$routes->get('admin/users/delete/(:any)', 'Admin::deleteUser/$1');
$routes->get('admin/kompetisi/cabor', 'Admin::dataCabor');
$routes->post('admin/cabor/add', 'Admin::addCabor');
$routes->post('admin/kompetisi/editCabor', 'Admin::editCabor');
$routes->get('admin/cabor/delete/(:num)', 'Admin::deleteCabor/$1');
$routes->get('admin/kompetisi/nomor-cabor', 'Admin::dataNomorCabor');
$routes->post('admin/kompetisi/nomor-cabor/add', 'Admin::addNomorCabor');
$routes->post('admin/kompetisi/nomor-cabor/edit/(:num)', 'Admin::editNomorCabor/$1');
$routes->post('api/toggle-nomor-cabor-per-item', 'Api::toggleStatusNomorCaborPerItem');
$routes->post('api/toggle-nomor-cabor-per-jenjang', 'Api::toggleStatusNomorCaborPerJenjang');
$routes->get('admin/ganti-password', 'Admin::ganti_password');
$routes->post('admin/ganti-password-attempt', 'Admin::ganti_password_attempt');
$routes->get('admin/rekap-data', 'Admin::rekap_data');
$routes->get('admin/setting', 'Admin::admin_setting');
$routes->get('admin/getCabor', 'Api::getCabor');
$routes->post('admin/getValidatorCabor', 'Api::getValidatorCabor');
$routes->post('admin/addValidatorCabor', 'Api::addValidatorCabor');
$routes->post('admin/deleteValidatorCabor', 'Api::deleteValidatorCabor');
$routes->get('admin/nomorcabor/delete/(:num)', 'Admin::deletenomorcabor/$1');
$routes->post('download/preview', 'Download::preview');
$routes->post('download/rekap-atlet-file', 'Download::rekap_atlet_file');
$routes->get('download/excel', 'Download::excel');
$routes->post('download/berkas-zip', 'Download::berkasZip');
$routes->post('download/datadiri-excel', 'Download::datadiriExcel');

// Validator Routes
$routes->get('validator/dashboard', 'Validator::dashboard');
$routes->get('validator/atlet/data', 'Validator::dataAtlet');
$routes->get('validator/atlet/add', 'Validator::addDataAtlet');
$routes->get('validator/atlet/edit/(:any)', 'Validator::editDataAtlet/$1');
$routes->post('validator/atlet/edit/(:any)', 'Validator::editDataAtlet_attempt/$1');
$routes->post('validator/atlet/add', 'Validator::addDataAtlet_attempt');
$routes->get('validator/atlet/delete/(:any)', 'Validator::deleteAtlet/$1');
$routes->get('validator/users/data', 'Validator::dataUsers');
$routes->get('validator/users/add', 'Validator::addDataUsers');
$routes->post('validator/users/add', 'Validator::addDataUsers_attempt');
$routes->post('validator/users/addValidator', 'Validator::addValidator');
$routes->post('validator/users/update', 'Validator::addDataUsers_attempt');
$routes->get('validator/users/delete/(:any)', 'Validator::deleteUser/$1');
$routes->get('validator/kompetisi/cabor', 'Validator::dataCabor');
$routes->post('validator/cabor/add', 'Validator::addCabor');
$routes->post('validator/kompetisi/editCabor', 'Validator::editCabor');
$routes->get('validator/cabor/delete/(:num)', 'Validator::deleteCabor/$1');
$routes->get('validator/kompetisi/nomor-cabor', 'Validator::dataNomorCabor');
$routes->post('validator/kompetisi/nomor-cabor/add', 'Validator::addNomorCabor');
$routes->post('validator/kompetisi/nomor-cabor/edit/(:num)', 'Validator::editNomorCabor/$1');
$routes->get('validator/nomorcabor/delete/(:num)', 'Validator::deletenomorcabor/$1');
$routes->get('validator/kompetisi/prestasi', 'Validator::dataKompetisiPrestasi');
$routes->get('validator/kompetisi/prestasi/(:any)', 'Validator::dataKompetisiPrestasiPeserta/$1');
$routes->get('validator/kompetisi/prestasi-add/(:any)', 'Validator::addDataPrestasi/$1');
$routes->post('validator/kompetisi/prestasi-add', 'Validator::addDataPrestasi_attempt');
$routes->post('validator/kompetisi/prestasi-edit', 'Validator::editPrestasi_attempt');
$routes->get('validator/prestasi/delete/(:num)/(:num)', 'Validator::deletePrestasi/$1/$2');
$routes->get('validator/ganti-password', 'Validator::ganti_password');
$routes->post('validator/ganti-password-attempt', 'Validator::ganti_password_attempt');
$routes->get('validator/rekap-data', 'Validator::rekap_data');

// Sekolah Routes
$routes->get('sekolah/dashboard', 'Sekolah::dashboard');
$routes->get('sekolah/atlet/data', 'Sekolah::dataAtlet');
$routes->get('sekolah/atlet/add', 'Sekolah::addDataAtlet');
$routes->get('sekolah/atlet/edit/(:any)', 'Sekolah::editDataAtlet/$1');
$routes->get('sekolah/atlet/edit-berkas/(:any)', 'Sekolah::editDataAtletBerkas/$1');
$routes->post('sekolah/atlet/edit/(:any)', 'Sekolah::editDataAtlet_attempt/$1');
$routes->post('sekolah/atlet/edit-berkas/(:any)', 'Sekolah::editDataAtletBerkas_attempt/$1');
$routes->post('sekolah/atlet/add', 'Sekolah::addDataAtlet_attempt');
$routes->get('sekolah/atlet/delete/(:any)', 'Sekolah::deleteAtlet/$1');
$routes->get('sekolah/users/data', 'Sekolah::dataUsers');
$routes->get('sekolah/users/add', 'Sekolah::addDataUsers');
$routes->post('sekolah/users/add', 'Sekolah::addDataUsers_attempt');
$routes->post('sekolah/users/update', 'Sekolah::addDataUsers_attempt');
$routes->get('sekolah/users/delete/(:any)', 'Sekolah::deleteUser/$1');
$routes->get('sekolah/ganti-password', 'Sekolah::ganti_password');
$routes->post('sekolah/ganti-password-attempt', 'Sekolah::ganti_password_attempt');
$routes->get('sekolah/kompetisi/data', 'Sekolah::dataKompetisi');
$routes->get('sekolah/kompetisi/add', 'Sekolah::addDataKompetisi');
$routes->post('sekolah/kompetisi/add', 'Sekolah::addDataKompetisi_attempt');
$routes->get('sekolah/kompetisi/add/(:num)', 'Sekolah::addDataKompetisi/$1');
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
$routes->post('api/cek-nik', 'Api::cekNik');
$routes->post('api/cek-nisn', 'Api::cekNisn');

// Kompetisi routes
$routes->get('admin/kompetisi/data', 'Admin::dataKompetisi');
$routes->get('admin/kompetisi/add', 'Admin::addDataKompetisi');
$routes->post('admin/kompetisi/add', 'Admin::addDataKompetisi_attempt');
$routes->get('admin/kompetisi/add/(:num)', 'Admin::addDataKompetisi/$1');
$routes->post('admin/kompetisi/add/', 'Admin::addDataKompetisi_attempt');
$routes->get('admin/kompetisi/edit/(:num)', 'Admin::editDataKompetisi/$1');
$routes->post('admin/kompetisi/edit/(:num)', 'Admin::editDataKompetisi_attempt/$1');
$routes->get('admin/kompetisi/delete/(:any)', 'Admin::deleteKompetisi/$1');
$routes->get('admin/kompetisi/peserta/(:num)', 'Admin::peserta/$1');
$routes->get('admin/kompetisi/peserta/add/(:num)', 'Admin::addDataPeserta/$1');
$routes->get('admin/kompetisi/peserta/view-idcard-kompetisi/(:num)', 'Admin::view_idcard_peserta/$1');
$routes->get('admin/kompetisi/peserta/delete/(:any)/(:num)', 'Admin::deletePeserta/$1/$2');
$routes->get('admin/kompetisi/prestasi', 'Admin::dataKompetisiPrestasi');
$routes->get('admin/kompetisi/prestasi/(:any)', 'Admin::dataKompetisiPrestasiPeserta/$1');
$routes->get('admin/kompetisi/prestasi-add/(:any)', 'Admin::addDataPrestasi/$1');
$routes->post('admin/kompetisi/prestasi-add', 'Admin::addDataPrestasi_attempt');
$routes->post('admin/kompetisi/prestasi-edit', 'Admin::editPrestasi_attempt');
$routes->get('admin/view-piagam/(:any)', 'Admin::view_piagam/$1');
$routes->get('admin/piagam-batch/(:any)', 'PdfController::piagam_batch/$1');
$routes->get('pdf/view-piagam/(:any)', 'PdfController::generate_pdf/$1');

// Prestasi
$routes->get('jurnal-medali', 'Admin::jurnal_medali');
$routes->get('jurnal-medali-kab/(:segment)', 'Admin::jurnal_medali_kab/$1');
$routes->get('export/jurnal-medali-excel', 'Export::jurnalMedaliExcel');
$routes->get('export/jurnal-medali-pdf', 'Export::jurnalMedaliPdf');
$routes->get('prestasi/delete/(:num)/(:num)', 'Admin::deletePrestasi/$1/$2');

// Operator Routes
// Debug endpoint removed (method was commented out)
$routes->get('admin/operator/data', 'Admin::dataOperator');
$routes->get('admin/operator/add', 'Admin::addOperator');
$routes->post('admin/operator/add', 'Admin::addOperator_attempt');
$routes->get('admin/operator/delete/(:segment)', 'Admin::deleteOperator/$1');

// API Routes
$routes->post('api/get-data-atlet-kab', 'Api::getDataAtletKab');
$routes->get('api/get-data-atlet-kab-v2', 'Api::getDataAtletKabv2');
$routes->get('api/get_detail_atlet', 'Api::getDetailAtlet');
$routes->get('api/validasi-dokumen', 'Api::validasi_dokumen');
$routes->match(['get', 'post'], 'api/validasi-semua', 'Api::validasi_semua');
$routes->get('api/validasi-atlet', 'Api::validasi_atlet');
$routes->post('api/set-atlet-valid', 'Api::set_atlet_valid');
$routes->post('api/init_atlet_validasi', 'Api::init_atlet_validasi');
$routes->post('api/simpan-catatan', 'Api::simpan_catatan');
$routes->post('api/get-catatan', 'Api::get_catatan');
$routes->post('api/getDataPesertaIDCard', 'Api::getDataPesertaIDCard');
$routes->post('api/getDataAtletIDCard', 'Api::getDataAtletIDCard');
$routes->get('api/get-peserta-kompetisi-caborsekolah/(:any)', 'Api::getPesertaKompetisiCaborSekolah/$1/$2');
$routes->post('api/get-status-user', 'Api::get_status_user');
$routes->post('api/toggle-status-user', 'Api::toggle_status_user');
$routes->post('api/toggle-nomor-cabor-status', 'Api::toggle_status_nocabor');
$routes->post('api/getNomorCabor', 'Api::getNomorCabor');
$routes->post('api/getNomorCaborPiagam', 'Api::getNomorCaborPiagam');
$routes->post('api/jurnal-medali-kab', 'Api::jurnal_medali_kab');
$routes->post('api/cek-regis-atlet-multi-cabor', 'Api::cekRegAtletMultiCabor');
$routes->post('api/getDataPesertaAddCaborByID', 'Api::getDataPesertaAddCaborByID');
$routes->post('api/toggle_admin_setting', 'Api::toggle_admin_setting');
$routes->post('api/getBanyakNomorCabor', 'Api::getBanyakNomorCabor');
$routes->get('api/getNomorLombaSekolah/(:any)/(:any)', 'Api::getNomorLombaSekolah/$1/$2');

// Validasi QR Code Routes
$routes->get('api/validasi/qr-code-atlet/(:segment)', 'Admin::validasi_peserta/$1');
$routes->get('api/verifikasi-piagam/(:segment)', 'Api::validasi_piagam/$1');

// Authentication Routes
$routes->post('auth/login', 'Auth::login');
$routes->post('auth/register-attempt', 'Auth::register_attempt');
$routes->get('/register', 'Auth::register');
$routes->get('login', 'Auth::loginForm');
$routes->get('/logout', 'Auth::logout');
