<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\StokMasukModel;

class StokMasukModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;
    protected $kategoriId;
    protected $supplierId;
    protected $produkId;

    protected $existingStokMasuk = [];
    protected $existingProduk = [];
    protected $existingSupplier = [];
    protected $existingKategori = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db    = \Config\Database::connect();
        $this->model = new StokMasukModel();

        // Backup data asli
        $this->existingStokMasuk = $this->db->table('stok_masuk')->get()->getResultArray();
        $this->existingProduk    = $this->db->table('produk')->get()->getResultArray();
        $this->existingSupplier  = $this->db->table('supplier')->get()->getResultArray();
        $this->existingKategori  = $this->db->table('kategori')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // Insert data dummy
        $this->db->table('kategori')->insert(['nama_kategori' => 'TEST_KATEGORI']);
        $this->kategoriId = $this->db->insertID();

        $this->db->table('supplier')->insert(['nama_supplier' => 'TEST_SUPPLIER', 'no_telp' => '08123']);
        $this->supplierId = $this->db->insertID();

        $this->db->table('produk')->insert([
            'nama_produk' => 'TEST_PRODUK',
            'harga'       => 1000,
            'stok'        => 10,
            'id_kategori' => $this->kategoriId,
            'id_supplier' => $this->supplierId,
        ]);
        $this->produkId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();

        // Restore data asli
        if (!empty($this->existingKategori))  $this->db->table('kategori')->insertBatch($this->existingKategori);
        if (!empty($this->existingSupplier))  $this->db->table('supplier')->insertBatch($this->existingSupplier);
        if (!empty($this->existingProduk))    $this->db->table('produk')->insertBatch($this->existingProduk);
        if (!empty($this->existingStokMasuk)) $this->db->table('stok_masuk')->insertBatch($this->existingStokMasuk);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertStokMasuk()
    {
        $result = $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 5,
            'tanggal'     => date('Y-m-d'),
        ]);
        $this->assertNotFalse($result);
    }

    public function testGetAllWithRelasi()
    {
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 10, 'tanggal' => date('Y-m-d')]);
        $result = $this->model->getAllWithRelasi();
        $this->assertCount(1, $result);
        $this->assertEquals('TEST_PRODUK', $result[0]['nama_produk']);
        $this->assertEquals('TEST_SUPPLIER', $result[0]['nama_supplier']);
        $this->assertEquals(10, $result[0]['jumlah']);
    }

    public function testGetByIdWithRelasi()
    {
        $id     = $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 7, 'tanggal' => date('Y-m-d')]);
        $result = $this->model->getByIdWithRelasi($id);
        $this->assertNotNull($result);
        $this->assertEquals(7, $result['jumlah']);
        $this->assertEquals('TEST_PRODUK', $result['nama_produk']);
        $this->assertEquals('TEST_SUPPLIER', $result['nama_supplier']);
    }

    public function testGetRecentStok()
    {
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 3, 'tanggal' => date('Y-m-d')]);
        $result = $this->model->getRecentStok(1);
        $this->assertCount(1, $result);
        $this->assertEquals(3, $result[0]['jumlah']);
    }

    public function testGetRecentHariIni()
    {
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 8, 'tanggal' => date('Y-m-d')]);
        $result = $this->model->getRecentHariIni(5);
        $this->assertCount(1, $result);
        $this->assertEquals(8, $result[0]['jumlah']);
    }

    public function testGetTotalStokMasuk()
    {
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 2, 'tanggal' => date('Y-m-d')]);
        $total = $this->model->getTotalStokMasuk();
        $this->assertEquals(1, $total);
    }

    public function testRecentStokSorting()
    {
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 1, 'tanggal' => '2024-01-01']);
        $this->model->insert(['id_produk' => $this->produkId, 'id_supplier' => $this->supplierId, 'jumlah' => 2, 'tanggal' => '2024-12-31']);
        $result = $this->model->getRecentStok(2);
        $this->assertEquals(2, $result[0]['jumlah']);
    }
}