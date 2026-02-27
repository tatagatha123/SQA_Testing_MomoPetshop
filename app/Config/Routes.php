<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/tambah', 'Produk::tambah');
$routes->get('/transaksi', 'Transaksi::index');
$routes->get('/transaksi/tambah', 'Transaksi::create');
$routes->post('/transaksi/simpan', 'Transaksi::simpan');
$routes->get('/laporan', 'Laporan::index');