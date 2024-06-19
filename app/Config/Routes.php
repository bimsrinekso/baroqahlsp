<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthLogin::index');
$routes->post('/login', 'AuthLogin::cekLogin');
$routes->get('/logout', 'AuthLogin::isLogout');
$routes->group('dashboard', static function ($routes){
    $routes->get('', 'Dashboard::index',['filter' => 'role:admin,HRD,karyawan']);
    $routes->group('golongan', static function ($routes){
        $routes->get('', 'GolonganController::index',['filter' => 'role:admin,HRD']);
        $routes->get('list', 'GolonganController::list',['filter' => 'role:admin,HRD']);
        $routes->get('create', 'GolonganController::create',['filter' => 'role:admin,HRD']);
        $routes->post('create', 'GolonganController::save',['filter' => 'role:admin,HRD']);
        $routes->get('edit/(:any)', 'GolonganController::edit/$1',['filter' => 'role:admin,HRD']);
        $routes->post('edit/(:any)', 'GolonganController::update/$1',['filter' => 'role:admin,HRD']);
        $routes->delete('delete/(:any)', 'GolonganController::delete/$1',['filter' => 'role:admin,HRD']);
    });
    $routes->group('karyawan', static function ($routes){
        $routes->get('', 'KaryawanController::index',['filter' => 'role:admin,HRD']);
        $routes->get('list', 'KaryawanController::list',['filter' => 'role:admin,HRD']);
        $routes->post('listUsers', 'KaryawanController::listUsers',['filter' => 'role:admin']);
        $routes->get('create', 'KaryawanController::create',['filter' => 'role:admin,HRD']);
        $routes->post('create', 'KaryawanController::save',['filter' => 'role:admin,HRD']);
        $routes->get('edit/(:any)', 'KaryawanController::edit/$1',['filter' => 'role:admin,HRD']);
        $routes->post('edit/(:any)', 'KaryawanController::update/$1',['filter' => 'role:admin,HRD']);
        $routes->delete('delete/(:any)', 'KaryawanController::delete/$1',['filter' => 'role:admin,HRD']);
    });

    $routes->group('gaji', static function ($routes){
        $routes->get('', 'GajiController::index',['filter' => 'role:admin,HRD,karyawan']);
        $routes->post('list', 'GajiController::list',['filter' => 'role:admin,HRD,karyawan']);
        $routes->post('pengeluaran', 'GajiController::totalPengeluaran',['filter' => 'role:admin,HRD']);
        $routes->post('create', 'GajiController::save',['filter' => 'role:admin,HRD']);
    });

    $routes->group('usermanage', static function ($routes){
        $routes->get('', 'UserManageController::index',['filter' => 'role:admin']);
        $routes->get('list', 'UserManageController::list',['filter' => 'role:admin']);
        $routes->get('role', 'UserManageController::getRole',['filter' => 'role:admin']);
        $routes->get('create', 'UserManageController::create',['filter' => 'role:admin']);
        $routes->post('create', 'UserManageController::save',['filter' => 'role:admin']);
        $routes->get('edit/(:any)', 'UserManageController::edit/$1',['filter' => 'role:admin']);
        $routes->post('edit/(:any)', 'UserManageController::update/$1',['filter' => 'role:admin']);
        $routes->delete('delete/(:any)', 'UserManageController::delete/$1',['filter' => 'role:admin']);
    });
});