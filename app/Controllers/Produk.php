<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use App\Models\StokMasukModel;

class Produk extends BaseController
{
    protected ProdukModel $produkModel;
    protected KategoriModel $kategoriModel;
    protected SupplierModel $supplierModel;
    protected StokMasukModel $stokMasukModel;

    public function __construct()
    {
        $this->produkModel    = new ProdukModel();
        $this->kategoriModel  = new KategoriModel();
        $this->supplierModel  = new SupplierModel();
        $this->stokMasukModel = new StokMasukModel();
    }

    // ===============================
    // LIST
    // ===============================
    public function index(): string
    {
        return view('produk', [
            'menu'          => 'produk',
            'nama_toko'     => 'Momo Petshop 🐶🐱',
            'daftar_produk' => $this->produkModel->getAllWithRelasi(),
            'title'         => 'Manajemen Produk',
        ]);
    }

    // ===============================
    // FORM TAMBAH
    // ===============================
    public function tambah(): string
    {
        return view('tambah_produk', [
            'menu'       => 'produk',
            'nama_toko'  => 'Momo Petshop 🐶🐱',
            'title'      => 'Tambah Produk',
            'produk'     => null,
            'kategoris'  => $this->kategoriModel->getForDropdown(),
            'suppliers'  => $this->supplierModel->findAll(),
            'validation' => null,
        ]);
    }

    // ===============================
    // STORE (UPLOAD + AUTO STOK MASUK)
    // ===============================
    public function store()
    {
        $rules = [
            'nama_produk' => 'required|max_length[255]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'id_kategori' => 'required|integer',
            'id_supplier' => 'required|integer',
            'foto_produk' => 'permit_empty|uploaded[foto_produk]|is_image[foto_produk]|max_size[foto_produk,2048]'
        ];

        if (! $this->validate($rules)) {
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

        $db = \Config\Database::connect();
        $db->transStart();

        // ===============================
        // HANDLE UPLOAD FOTO
        // ===============================
        $file = $this->request->getFile('foto_produk');
        $namaFile = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/produk', $namaFile);
        }

        // ===============================
        // INSERT KE PRODUK
        // ===============================
        $idProduk = $this->produkModel->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_supplier' => $this->request->getPost('id_supplier'),
            'foto_produk' => $namaFile,
        ]);

        // ===============================
        // AUTO INSERT KE STOK MASUK
        // ===============================
        $this->stokMasukModel->insert([
            'id_produk'   => $idProduk,
            'id_supplier' => $this->request->getPost('id_supplier'),
            'jumlah'      => $this->request->getPost('stok'),
            'tanggal'     => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        return redirect()->to('/produk')
            ->with('success', 'Produk berhasil ditambahkan dan otomatis masuk ke stok masuk.');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit(int $id): string
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk tidak ditemukan.");
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

    // ===============================
    // UPDATE (DENGAN GANTI FOTO)
    // ===============================
    public function update(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk tidak ditemukan.");
        }

        $file = $this->request->getFile('foto_produk');
        $namaFile = $produk['foto_produk'];

        // Jika upload foto baru
        if ($file && $file->isValid() && !$file->hasMoved()) {

            // Hapus foto lama jika ada
            if (!empty($produk['foto_produk']) && 
                file_exists(FCPATH . 'uploads/produk/' . $produk['foto_produk'])) {
                unlink(FCPATH . 'uploads/produk/' . $produk['foto_produk']);
            }

            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/produk', $namaFile);
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_supplier' => $this->request->getPost('id_supplier'),
            'foto_produk' => $namaFile,
        ]);

        return redirect()->to('/produk')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // ===============================
    // DELETE (HAPUS FOTO JUGA)
    // ===============================
    public function delete(int $id)
    {
        $produk = $this->produkModel->find($id);

        if (! $produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk tidak ditemukan.");
        }

        // Hapus file foto jika ada
        if (!empty($produk['foto_produk']) && 
            file_exists(FCPATH . 'uploads/produk/' . $produk['foto_produk'])) {
            unlink(FCPATH . 'uploads/produk/' . $produk['foto_produk']);
        }

        $this->produkModel->delete($id);

        return redirect()->to('/produk')
            ->with('success', 'Produk berhasil dihapus.');
    }
}