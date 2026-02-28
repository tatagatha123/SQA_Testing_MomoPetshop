<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Laporan extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new TransaksiModel();

        $data = [
            'title'           => 'Laporan',
            'menu'            => 'laporan',
            'transaksi'       => $transaksiModel->getAllWithKasir(),
            'totalTransaksi'  => $transaksiModel->countAll(),
            'totalPendapatan' => $transaksiModel->getTotalPendapatan(),
        ];

        return view('laporan/index', $data);
    }
}