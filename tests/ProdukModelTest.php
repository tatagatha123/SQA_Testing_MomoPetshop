<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\ProdukModel;

class ProdukModelTest extends CIUnitTestCase
{
    // protected $model;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->model = new ProdukModel();
    // }

    // // Tambah produk valid
    // public function testInsertProdukValid()
    // {
    //     $kategori = $this->db->table('kategori')->get()->getRowArray();
    //     $supplier = $this->db->table('supplier')->get()->getRowArray();

    //     $data = [
    //         'nama_produk' => 'Makanan Kucing',
    //         'harga' => 10000.50,
    //         'stok' => 10,
    //         'id_kategori' => $kategori['id_kategori'],
    //         'id_supplier' => $supplier['id_supplier'],
    //     ];

    //     $result = $this->model->insert($data);

    //     $this->assertNotFalse($result);
    // }

    // // Nama produk kosong
    // public function testInsertProdukNamaKosong()
    // {
    //     $data = [
    //         'nama_produk' => '',
    //         'harga' => 10000,
    //         'stok' => 10,
    //         'id_kategori' => 1,
    //         'id_supplier' => 1,
    //     ];

    //     $result = $this->model->insert($data);

    //     $this->assertFalse($result);
    // }

    // // Harga bukan angka
    // public function testInsertProdukHargaInvalid()
    // {
    //     $data = [
    //         'nama_produk' => 'Produk Test',
    //         'harga' => 'abc',
    //         'stok' => 10,
    //         'id_kategori' => 1,
    //         'id_supplier' => 1,
    //     ];

    //     $result = $this->model->insert($data);

    //     $this->assertFalse($result);
    // }

    // // Stok bukan integer
    // public function testInsertProdukStokInvalid()
    // {
    //     $data = [
    //         'nama_produk' => 'Produk Test',
    //         'harga' => 10000,
    //         'stok' => 'abc',
    //         'id_kategori' => 1,
    //         'id_supplier' => 1,
    //     ];

    //     $result = $this->model->insert($data);

    //     $this->assertFalse($result);
    // }

    // // Test ambil semua produk
    // public function testGetAllProduk()
    // {
    //     $result = $this->model->findAll();

    //     $this->assertIsArray($result);
    // }

    // // Test stok rendah
    // public function testProdukStokRendah()
    // {
    //     $result = $this->model->getProdukStokRendah(5);

    //     $this->assertIsArray($result);
    // }

    // // Test total produk
    // public function testTotalProduk()
    // {
    //     $result = $this->model->getTotalProduk();

    //     $this->assertIsInt($result);
    // }
}