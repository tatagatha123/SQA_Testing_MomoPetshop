<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;

class Produk extends BaseController
{
    protected ProdukModel   $produkModel;
    protected KategoriModel $kategoriModel;
    protected SupplierModel $supplierModel;

    public function __construct()
    {
        $this->produkModel   = new ProdukModel();
        $this->kategoriModel = new KategoriModel();
        $this->supplierModel = new SupplierModel();
    }

    // ─────────────────────────────────────────
    // LIST — GET /produk
    // ─────────────────────────────────────────
    public function index(): string
    {
        $data = [
            'menu'          => 'produk',
            'nama_toko'     => 'Momo Petshop 🐶🐱',
            'daftar_produk' => $this->produkModel->getAllWithRelasi(),
            'notif_transaksi' => 0,
            'title'         => 'Manajemen Produk',
        ];

        return view('produk', $data);
    }

    // ─────────────────────────────────────────
    // FORM TAMBAH — GET /produk/tambah
    // ─────────────────────────────────────────
    public function tambah(): string
    {
        $data = [
            'menu'       => 'produk',
            'nama_toko'  => 'Momo Petshop 🐶🐱',
            'title'      => 'Tambah Produk',
            'produk'     => null,
            'kategoris'  => $this->kategoriModel->getForDropdown(),
            'suppliers'  => $this->supplierModel->findAll(),
            'validation' => null,
        ];

        return view('tambah_produk', $data);
    }

    // ─────────────────────────────────────────
    // SIMPAN — POST /produk/store
    // ─────────────────────────────────────────
    public function store()
    {
        $rules = [
            'nama_produk' => 'required|max_length[255]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'id_kategori' => 'required|integer',
            'id_supplier' => 'required|integer',
        ];

        $messages = [
            'nama_produk' => [
                'required'   => 'Nama produk wajib diisi.',
                'max_length' => 'Nama produk maksimal 255 karakter.',
            ],
            'harga'       => ['required' => 'Harga wajib diisi.', 'numeric' => 'Harga harus angka.'],
            'stok'        => ['required' => 'Stok wajib diisi.', 'integer' => 'Stok harus angka.'],
            'id_kategori' => ['required' => 'Kategori wajib dipilih.'],
            'id_supplier' => ['required' => 'Supplier wajib dipilih.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return view('tambah_produk', [
                'menu'       => 'produk',
                'nama_toko'  => 'Momo Petshop 🐶🐱',
                'title'      => 'Tambah Produk',
                'produk'     => null,
                'kategoris'  => $this->kategoriModel->getForDropdown(),
                'suppliers'  => $this->supplierModel->findAll(),
                'validation' => $this->validator,
            ]);
        }

        $this->produkModel->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_supplier' => $this->request->getPost('id_supplier'),
        ]);

        return redirect()->to('/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────
    // FORM EDIT — GET /produk/edit/{id}
    // ─────────────────────────────────────────
    public function edit(int $id): string
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk dengan ID $id tidak ditemukan.");
        }

        return view('tambah_produk', [
            'menu'       => 'produk',
            'nama_toko'  => 'Momo Petshop 🐶🐱',
            'title'      => 'Edit Produk',
            'produk'     => $produk,
            'kategoris'  => $this->kategoriModel->getForDropdown(),
            'suppliers'  => $this->supplierModel->findAll(),
            'validation' => null,
        ]);
    }

    // ─────────────────────────────────────────
    // UPDATE — POST /produk/update/{id}
    // ─────────────────────────────────────────
    public function update(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk dengan ID $id tidak ditemukan.");
        }

        $rules = [
            'nama_produk' => 'required|max_length[255]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'id_kategori' => 'required|integer',
            'id_supplier' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return view('tambah_produk', [
                'menu'       => 'produk',
                'nama_toko'  => 'Momo Petshop 🐶🐱',
                'title'      => 'Edit Produk',
                'produk'     => $produk,
                'kategoris'  => $this->kategoriModel->getForDropdown(),
                'suppliers'  => $this->supplierModel->findAll(),
                'validation' => $this->validator,
            ]);
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_supplier' => $this->request->getPost('id_supplier'),
        ]);

        return redirect()->to('/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    // ─────────────────────────────────────────
    // HAPUS — GET /produk/delete/{id}
    // ─────────────────────────────────────────
    public function delete(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk dengan ID $id tidak ditemukan.");
        }

        $this->produkModel->delete($id);

        return redirect()->to('/produk')->with('success', 'Produk berhasil dihapus.');
    }
}