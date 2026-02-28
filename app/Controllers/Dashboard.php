<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\StokMasukModel;
use App\Models\ProdukModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // ── Proteksi: harus login ──
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new TransaksiModel();
        $stokMasukModel = new StokMasukModel();
        $produkModel    = new ProdukModel();

        $data = [
            'menu'             => 'dashboard',
            'nama_toko'        => 'Momo Petshop 🐶🐱',

            // ✅ Nama kasir dari session (siapa yang login)
            'kasir'            => session()->get('username') ?? 'Admin',

            // ✅ Total produk dari DB
            'total_produk'     => $produkModel->countAll(),

            // ✅ Total semua transaksi dari DB
            'total_transaksi'  => $transaksiModel->countAll(),

            // ✅ Total pendapatan = SUM kolom total dari tabel transaksi
            'total_pendapatan' => $transaksiModel->getTotalPendapatan(),

            // ✅ Jumlah transaksi hari ini (untuk badge notif)
            'notif_transaksi'  => $transaksiModel->getCountHariIni(),

            // ✅ 5 transaksi terbaru hari ini
            'recent_transaksi' => $transaksiModel->getRecentHariIni(5),

            // ✅ 5 stok masuk terbaru hari ini
            'recent_stok'      => $stokMasukModel->getRecentHariIni(5),
        ];

        return view('dashboard', $data);
    }
}