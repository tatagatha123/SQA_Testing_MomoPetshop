<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'nama_toko' => 'Momo Petshop 🐶🐱',
            'kasir' => 'Agatha',
            'total_produk' => 15,
            'total_transaksi' => 8,
            'total_pendapatan' => 1250000,
            'menu' => 'dashboard', // 🔥 penanda menu aktif
            'notif_transaksi' => 3 // 🔥 contoh notifikasi transaksi baru
        ];

        return view('dashboard', $data);
    }
}