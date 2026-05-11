<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\ProdukModel;

class ProdukModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;
    protected $kategori;
    protected $supplier;

    protected $existingProduk = [];
    protected $existingKategori = [];
    protected $existingSupplier = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db    = \Config\Database::connect();
        $this->model = new ProdukModel();

        // Backup data asli
        $this->existingProduk   = $this->db->table('produk')->get()->getResultArray();
        $this->existingKategori = $this->db->table('kategori')->get()->getResultArray();
        $this->existingSupplier = $this->db->table('supplier')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('produk')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // Insert dummy
        $this->db->table('kategori')->insert(['nama_kategori' => 'Kategori Test']);
        $this->db->table('supplier')->insert(['nama_supplier' => 'Supplier Test', 'no_telp' => '08123']);

        $this->kategori = $this->db->table('kategori')->get()->getRowArray();
        $this->supplier = $this->db->table('supplier')->get()->getRowArray();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('produk')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('supplier')->truncate();

        // Restore data asli
        if (!empty($this->existingKategori)) $this->db->table('kategori')->insertBatch($this->existingKategori);
        if (!empty($this->existingSupplier)) $this->db->table('supplier')->insertBatch($this->existingSupplier);
        if (!empty($this->existingProduk))   $this->db->table('produk')->insertBatch($this->existingProduk);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertProdukValid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Makanan Kucing',
            'harga'       => 10000,
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $this->assertNotFalse($result);
    }

    public function testInsertProdukNamaKosong()
    {
        $result = $this->model->insert([
            'nama_produk' => '',
            'harga'       => 10000,
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $this->assertFalse($result);
    }

    public function testInsertProdukHargaInvalid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Produk Test',
            'harga'       => 'abc',
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $this->assertFalse($result);
    }

    public function testInsertProdukStokInvalid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Produk Test',
            'harga'       => 10000,
            'stok'        => 'abc',
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $this->assertFalse($result);
    }

    public function testGetAllProduk()
    {
        $this->model->insert([
            'nama_produk' => 'Produk A',
            'harga'       => 10000,
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $result = $this->model->findAll();
        $this->assertCount(1, $result);
        $this->assertEquals('Produk A', $result[0]['nama_produk']);
    }

    public function testProdukStokRendah()
    {
        $this->model->insert([
            'nama_produk' => 'Produk Low',
            'harga'       => 10000,
            'stok'        => 2,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $result = $this->model->getProdukStokRendah(5);
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['stok']);
    }

    public function testTotalProduk()
    {
        $this->model->insert([
            'nama_produk' => 'Produk A',
            'harga'       => 10000,
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $total = $this->model->getTotalProduk();
        $this->assertEquals(1, $total);
    }

    public function testGetAllWithRelasi()
    {
        $this->model->insert([
            'nama_produk' => 'Produk Relasi',
            'harga'       => 10000,
            'stok'        => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);
        $result = $this->model->getAllWithRelasi();
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('nama_kategori', $result[0]);
        $this->assertArrayHasKey('nama_supplier', $result[0]);
    }
}