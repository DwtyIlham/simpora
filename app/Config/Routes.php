<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Admin Routes
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::dashboard');
$routes->get('admin/atlet/data', 'Home::dataAtlet');
$routes->get('admin/atlet/add', 'Home::addDataAtlet');
$routes->get('admin/atlet/edit/(:any)', 'Home::editDataAtlet/$1');
$routes->post('admin/atlet/edit/(:any)', 'Home::editDataAtlet_attempt/$1');
$routes->post('admin/atlet/add', 'Home::addDataAtlet_attempt');
$routes->get('admin/atlet/delete/(:any)', 'Home::deleteAtlet/$1');
$routes->get('admin/users/data', 'Home::dataUsers');
$routes->get('admin/users/add', 'Home::addDataUsers');
$routes->post('admin/users/add', 'Home::addDataUsers_attempt');
$routes->post('admin/users/update', 'Home::addDataUsers_attempt');
$routes->get('admin/users/delete/(:any)', 'Home::deleteUser/$1');

// Kompetisi routes
$routes->get('admin/kompetisi/data', 'Home::dataKompetisi');
$routes->get('admin/kompetisi/add', 'Home::addDataKompetisi');
$routes->post('admin/kompetisi/add', 'Home::addDataKompetisi_attempt');
$routes->get('admin/kompetisi/add/(:num)', 'Home::addDataKompetisi/$1');
$routes->post('admin/kompetisi/add/(:num)', 'Home::addDataKompetisi_attempt/$1');
$routes->get('admin/kompetisi/delete/(:any)', 'Home::deleteKompetisi/$1');
$routes->get('admin/kompetisi/peserta/(:num)', 'Home::peserta/$1');
$routes->get('admin/kompetisi/peserta/add/(:num)', 'Home::addDataPeserta/$1');
$routes->get('admin/kompetisi/peserta/view-idcard-kompetisi/(:num)', 'Home::view_idcard_peserta/$1');
$routes->post('admin/kompetisi/peserta/add', 'Home::addDataPeserta_attempt');
$routes->get('admin/kompetisi/peserta/delete/(:any)/(:num)', 'Home::deletePeserta/$1/$2');

// Sekolah Routes

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

// Authentication Routes
$routes->post('auth/login', 'Auth::login');
$routes->post('auth/register-attempt', 'Auth::register_attempt');
$routes->get('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');
