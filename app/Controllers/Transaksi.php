<?php

namespace App\Controllers;

class Transaksi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Transaksi',
            'menu' => 'transaksi',
            'transaksi' => [
                [
                    'kode' => 'TRX001',
                    'tanggal' => '2026-02-22',
                    'total' => 150000
                ],
                [
                    'kode' => 'TRX002',
                    'tanggal' => '2026-02-23',
                    'total' => 275000
                ],
                [
                    'kode' => 'TRX003',
                    'tanggal' => '2026-02-23',
                    'total' => 99000
                ]
            ]
        ];

        return view('transaksi/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Transaksi',
            'menu'  => 'transaksi'
        ];

        return view('transaksi/create', $data);
    }

    public function simpan()
    {
        $kode   = $this->request->getPost('kode');
        $tanggal = $this->request->getPost('tanggal');
        $total   = $this->request->getPost('total');

    // Untuk latihan dulu kita tampilkan saja
        return redirect()->to('/transaksi');
}
}