<?php

namespace App\Controllers;

class Produk extends BaseController
{
    public function index()
    {
        $data = [
            'menu' => 'produk',
            'nama_toko' => 'Momo Petshop 🐶🐱',
            'daftar_produk' => [
                ['nama' => 'Makanan Kucing', 'harga' => 50000],
                ['nama' => 'Makanan Anjing', 'harga' => 75000],
                ['nama' => 'Shampoo Hewan', 'harga' => 30000],
            ],
            'notif_transaksi' => 3
        ];

        return view('produk', $data);
    }

    public function tambah()
    {
        $data = [
            'menu' => 'produk',
            'notif_transaksi' => 3
        ];

        return view('tambah_produk', $data);
    }
}