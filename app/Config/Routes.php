<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Redirect root
$routes->get('/', function() {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard');
    }
    return redirect()->to('/login');
});

// ─────────────────────────────────────────────
// AUTH (tidak perlu login)
// ─────────────────────────────────────────────
$routes->get('/login',     'Auth::login');
$routes->post('/login',    'Auth::loginProses');
$routes->get('/register',  'Auth::register');
$routes->post('/register', 'Auth::registerProses');
$routes->get('/logout',    'Auth::logout'); // ← diubah dari Auth::login ke Auth::logout

// ─────────────────────────────────────────────
// PROTECTED ROUTES (harus login)
// ─────────────────────────────────────────────
$routes->group('', ['filter' => 'auth'], function($routes) {

    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');

    // Produk
    $routes->get('produk',                 'Produk::index');
    $routes->get('produk/tambah',          'Produk::tambah');
    $routes->post('produk/store',          'Produk::store');
    $routes->get('produk/edit/(:num)',     'Produk::edit/$1');
    $routes->post('produk/update/(:num)',  'Produk::update/$1');
    $routes->get('produk/delete/(:num)',   'Produk::delete/$1');

    // Transaksi
    $routes->get('/transaksi',               'Transaksi::index');
    $routes->get('/transaksi/tambah',        'Transaksi::create');
    $routes->post('/transaksi/simpan',       'Transaksi::simpan');
    $routes->get('/transaksi/detail/(:num)', 'Transaksi::detail/$1');

    // Laporan
    $routes->get('/laporan', 'Laporan::index');

    // Stok Masuk
    $routes->get('stok-masuk',                'StokMasuk::index');
    $routes->get('stok-masuk/create',         'StokMasuk::create');
    $routes->post('stok-masuk/store',         'StokMasuk::store');
    $routes->get('stok-masuk/edit/(:num)',    'StokMasuk::edit/$1');
    $routes->post('stok-masuk/update/(:num)', 'StokMasuk::update/$1');
    $routes->get('stok-masuk/delete/(:num)',  'StokMasuk::delete/$1');

    // User
    $routes->get('/user',               'User::index');
    $routes->get('/user/create',        'User::create');
    $routes->post('/user/store',        'User::store');
    $routes->get('/user/delete/(:num)', 'User::delete/$1');
});