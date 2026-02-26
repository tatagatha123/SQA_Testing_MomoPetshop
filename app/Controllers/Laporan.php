<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function index()
    {
        // Dummy data transaksi
        $transaksi = [
            ['kode' => 'TRX001', 'tanggal' => '2026-02-22', 'total' => 150000],
            ['kode' => 'TRX002', 'tanggal' => '2026-02-23', 'total' => 275000],
            ['kode' => 'TRX003', 'tanggal' => '2026-02-23', 'total' => 99000],
        ];

        // Hitung total
        $totalPendapatan = 0;
        foreach ($transaksi as $trx) {
            $totalPendapatan += $trx['total'];
        }

        $data = [
            'title' => 'Laporan',
            'menu'  => 'laporan',
            'transaksi' => $transaksi,
            'totalTransaksi' => count($transaksi),
            'totalPendapatan' => $totalPendapatan
        ];

        return view('laporan/index', $data);
    }
}