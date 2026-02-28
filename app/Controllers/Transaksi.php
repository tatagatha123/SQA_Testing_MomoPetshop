<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\ProdukModel;

class Transaksi extends BaseController
{
    protected TransaksiModel       $transaksiModel;
    protected DetailTransaksiModel $detailModel;
    protected ProdukModel          $produkModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel    = new DetailTransaksiModel();
        $this->produkModel    = new ProdukModel();
    }

    // ─────────────────────────────────────────
    // LIST — GET /transaksi
    // ─────────────────────────────────────────
    public function index(): string
    {
        $transaksi = $this->transaksiModel->getAllTransaksi();

        $data = [
            'title'            => 'Data Transaksi',
            'menu'             => 'transaksi',
            'nama_toko'        => 'Momo Petshop 🐶🐱',
            'transaksi'        => $transaksi,
            'total_pendapatan' => $this->transaksiModel->getTotalPendapatan(),
            'count_hari_ini'   => $this->transaksiModel->getCountHariIni(),
            'notif_transaksi'  => 0,
        ];

        return view('transaksi/index', $data);
    }

    // ─────────────────────────────────────────
    // FORM TAMBAH — GET /transaksi/tambah
    // ─────────────────────────────────────────
    public function create(): string
    {
        $data = [
            'title'           => 'Tambah Transaksi',
            'menu'            => 'transaksi',
            'nama_toko'       => 'Momo Petshop 🐶🐱',
            'daftar_produk'   => $this->produkModel->getAllWithRelasi(),
            'notif_transaksi' => 0,
        ];

        return view('transaksi/create', $data);
    }

    // ─────────────────────────────────────────
    // SIMPAN — POST /transaksi/simpan
    // ─────────────────────────────────────────
    public function simpan()
    {
        $tanggal   = $this->request->getPost('tanggal');
        $total     = $this->request->getPost('total');
        $produks   = $this->request->getPost('id_produk');   // array
        $qtys      = $this->request->getPost('qty');          // array
        $hargas    = $this->request->getPost('harga');        // array

        // Validasi minimal
        if (empty($produks) || empty($tanggal)) {
            return redirect()->back()->with('error', 'Data transaksi tidak lengkap.')->withInput();
        }

        // Ambil id_user dari session (sesuaikan dengan sistem auth kamu)
        $id_user = session()->get('id_user') ?? 1;

        // Simpan header transaksi
        $id_transaksi = $this->transaksiModel->insert([
            'id_user' => $id_user,
            'tanggal' => $tanggal,
            'total'   => $total,
        ]);

        if (! $id_transaksi) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.')->withInput();
        }

        // Simpan detail transaksi (satu per satu)
        foreach ($produks as $i => $id_produk) {
            $qty      = (int)   ($qtys[$i]   ?? 0);
            $harga    = (float) ($hargas[$i] ?? 0);
            $subtotal = $qty * $harga;

            if ($qty <= 0 || $id_produk <= 0) continue;

            $this->detailModel->insert([
                'id_transaksi' => $id_transaksi,
                'id_produk'    => $id_produk,
                'qty'          => $qty,
                'harga'        => $harga,
                'subtotal'     => $subtotal,
            ]);

            // Kurangi stok produk
            $produk = $this->produkModel->find($id_produk);
            if ($produk) {
                $stokBaru = max(0, $produk['stok'] - $qty);
                $this->produkModel->update($id_produk, ['stok' => $stokBaru]);
            }
        }

        return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan.');
    }

    // ─────────────────────────────────────────
    // DETAIL (AJAX) — GET /transaksi/detail/{id}
    // ─────────────────────────────────────────
    public function detail(int $id)
    {
        $transaksi = $this->transaksiModel->getById($id);

        if (! $transaksi) {
            return $this->response->setJSON(['error' => 'Transaksi tidak ditemukan'])->setStatusCode(404);
        }

        $detail = $this->detailModel->getByTransaksi($id);

        return $this->response->setJSON([
            'transaksi' => $transaksi,
            'detail'    => $detail,
        ]);
    }
}