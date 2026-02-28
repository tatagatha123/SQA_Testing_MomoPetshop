<?php

namespace App\Controllers;

use App\Models\StokMasukModel;
use App\Models\ProdukModel;
use App\Models\SupplierModel;

class StokMasuk extends BaseController
{
    protected StokMasukModel $stokMasukModel;
    protected ProdukModel    $produkModel;
    protected SupplierModel  $supplierModel;
    protected $session;

    public function __construct()
    {
        $this->stokMasukModel = new StokMasukModel();
        $this->produkModel    = new ProdukModel();
        $this->supplierModel  = new SupplierModel();
        $this->session        = \Config\Services::session();
    }

    // ── Helper: data layout yang selalu dipakai ──
    private function layoutData(array $extra = []): array
    {
        return array_merge([
            'nama_toko' => $this->session->get('nama_toko') ?? 'MomoPetshop',
            'kasir'     => $this->session->get('nama')      ?? 'Admin',
            'menu'      => 'stok_masuk',
        ], $extra);
    }

    // ── INDEX: Daftar semua stok masuk ──
    public function index()
    {
        $data = $this->layoutData([
            'title'      => 'Stok Masuk',
            'stok_masuk' => $this->stokMasukModel->getAllWithRelasi(),
            'total_stok' => $this->stokMasukModel->getTotalStokMasuk(),
        ]);

        return view('stok_masuk/index', $data);
    }

    // ── CREATE: Tampilkan form tambah ──
    public function create()
    {
        $data = $this->layoutData([
            'title'      => 'Tambah Stok Masuk',
            'produk'     => $this->produkModel->findAll(),
            'supplier'   => $this->supplierModel->findAll(),
            'validation' => \Config\Services::validation(),
        ]);

        return view('stok_masuk/create', $data);
    }

    // ── STORE: Simpan data baru ──
    public function store()
    {
        $rules = [
            'id_produk'   => ['label' => 'Produk',   'rules' => 'required|integer'],
            'id_supplier' => ['label' => 'Supplier',  'rules' => 'required|integer'],
            'jumlah'      => ['label' => 'Jumlah',    'rules' => 'required|integer|greater_than[0]'],
            'tanggal'     => ['label' => 'Tanggal',   'rules' => 'required|valid_date'],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idProduk = (int) $this->request->getPost('id_produk');
        $jumlah   = (int) $this->request->getPost('jumlah');

        // Simpan ke stok_masuk
        $this->stokMasukModel->insert([
            'id_produk'   => $idProduk,
            'id_supplier' => (int) $this->request->getPost('id_supplier'),
            'jumlah'      => $jumlah,
            'tanggal'     => $this->request->getPost('tanggal'),
        ]);

        // Update kolom stok di tabel produk
        $produk = $this->produkModel->find($idProduk);
        if ($produk) {
            $this->produkModel->update($idProduk, [
                'stok' => ($produk['stok'] ?? 0) + $jumlah,
            ]);
        }

        return redirect()->to('/stok-masuk')->with('success', 'Stok masuk berhasil ditambahkan!');
    }

    // ── EDIT: Tampilkan form edit ──
    public function edit(int $id_stok)
    {
        $stok = $this->stokMasukModel->getByIdWithRelasi($id_stok);
        if (!$stok) {
            return redirect()->to('/stok-masuk')->with('error', 'Data tidak ditemukan.');
        }

        $data = $this->layoutData([
            'title'      => 'Edit Stok Masuk',
            'stok'       => $stok,
            'produk'     => $this->produkModel->findAll(),
            'supplier'   => $this->supplierModel->findAll(),
            'validation' => \Config\Services::validation(),
        ]);

        return view('stok_masuk/edit', $data);
    }

    // ── UPDATE: Simpan perubahan ──
    public function update(int $id_stok)
    {
        $rules = [
            'id_produk'   => ['label' => 'Produk',   'rules' => 'required|integer'],
            'id_supplier' => ['label' => 'Supplier',  'rules' => 'required|integer'],
            'jumlah'      => ['label' => 'Jumlah',    'rules' => 'required|integer|greater_than[0]'],
            'tanggal'     => ['label' => 'Tanggal',   'rules' => 'required|valid_date'],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $stokLama = $this->stokMasukModel->find($id_stok);
        if (!$stokLama) {
            return redirect()->to('/stok-masuk')->with('error', 'Data tidak ditemukan.');
        }

        $idProdukBaru  = (int) $this->request->getPost('id_produk');
        $jumlahBaru    = (int) $this->request->getPost('jumlah');
        $idProdukLama  = (int) $stokLama['id_produk'];
        $jumlahLama    = (int) $stokLama['jumlah'];

        // Update tabel stok_masuk
        $this->stokMasukModel->update($id_stok, [
            'id_produk'   => $idProdukBaru,
            'id_supplier' => (int) $this->request->getPost('id_supplier'),
            'jumlah'      => $jumlahBaru,
            'tanggal'     => $this->request->getPost('tanggal'),
        ]);

        // Sinkron stok produk
        // Jika produk berubah: kembalikan stok lama, tambah ke produk baru
        if ($idProdukBaru !== $idProdukLama) {
            $produkLama = $this->produkModel->find($idProdukLama);
            if ($produkLama) {
                $this->produkModel->update($idProdukLama, [
                    'stok' => max(0, ($produkLama['stok'] ?? 0) - $jumlahLama),
                ]);
            }
            $produkBaru = $this->produkModel->find($idProdukBaru);
            if ($produkBaru) {
                $this->produkModel->update($idProdukBaru, [
                    'stok' => ($produkBaru['stok'] ?? 0) + $jumlahBaru,
                ]);
            }
        } else {
            // Produk sama, cukup hitung selisih
            $selisih = $jumlahBaru - $jumlahLama;
            if ($selisih !== 0) {
                $produk = $this->produkModel->find($idProdukBaru);
                if ($produk) {
                    $this->produkModel->update($idProdukBaru, [
                        'stok' => max(0, ($produk['stok'] ?? 0) + $selisih),
                    ]);
                }
            }
        }

        return redirect()->to('/stok-masuk')->with('success', 'Stok masuk berhasil diperbarui!');
    }

    // ── DELETE: Hapus data & kurangi stok produk ──
    public function delete(int $id_stok)
    {
        $stok = $this->stokMasukModel->find($id_stok);
        if (!$stok) {
            return redirect()->to('/stok-masuk')->with('error', 'Data tidak ditemukan.');
        }

        // Kurangi stok produk
        $produk = $this->produkModel->find($stok['id_produk']);
        if ($produk) {
            $this->produkModel->update($stok['id_produk'], [
                'stok' => max(0, ($produk['stok'] ?? 0) - $stok['jumlah']),
            ]);
        }

        $this->stokMasukModel->delete($id_stok);

        return redirect()->to('/stok-masuk')->with('success', 'Data stok masuk berhasil dihapus.');
    }
}
