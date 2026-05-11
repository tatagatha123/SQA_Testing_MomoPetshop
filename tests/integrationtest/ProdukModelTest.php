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

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new ProdukModel();

        // reset semua tabel terkait
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('produk')->emptyTable();
        $this->db->table('kategori')->emptyTable();
        $this->db->table('supplier')->emptyTable();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // insert kategori dummy
        $this->db->table('kategori')->insert([
            'nama_kategori' => 'Kategori Test'
        ]);

        // insert supplier dummy
        $this->db->table('supplier')->insert([
            'nama_supplier' => 'Supplier Test'
        ]);

        // ambil ID hasil insert
        $this->kategori = $this->db->table('kategori')->get()->getRowArray();
        $this->supplier = $this->db->table('supplier')->get()->getRowArray();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('produk')->emptyTable();
        $this->db->table('kategori')->emptyTable();
        $this->db->table('supplier')->emptyTable();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    // INSERT VALID
    public function testInsertProdukValid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Makanan Kucing',
            'harga' => 10000,
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $this->assertNotFalse($result);
    }

    // NAMA KOSONG
    public function testInsertProdukNamaKosong()
    {
        $result = $this->model->insert([
            'nama_produk' => '',
            'harga' => 10000,
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $this->assertFalse($result);
    }

    // HARGA INVALID
    public function testInsertProdukHargaInvalid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Produk Test',
            'harga' => 'abc',
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $this->assertFalse($result);
    }

    // STOK INVALID
    public function testInsertProdukStokInvalid()
    {
        $result = $this->model->insert([
            'nama_produk' => 'Produk Test',
            'harga' => 10000,
            'stok' => 'abc',
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $this->assertFalse($result);
    }

    // GET ALL PRODUK
    public function testGetAllProduk()
    {
        $this->model->insert([
            'nama_produk' => 'Produk A',
            'harga' => 10000,
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $result = $this->model->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('Produk A', $result[0]['nama_produk']);
    }

    // STOK RENDAH
    public function testProdukStokRendah()
    {
        $this->model->insert([
            'nama_produk' => 'Produk Low',
            'harga' => 10000,
            'stok' => 2,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $result = $this->model->getProdukStokRendah(5);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['stok']);
    }

    // TOTAL PRODUK
    public function testTotalProduk()
    {
        $this->model->insert([
            'nama_produk' => 'Produk A',
            'harga' => 10000,
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $total = $this->model->getTotalProduk();

        $this->assertEquals(1, $total);
    }

    // JOIN RELASI
    public function testGetAllWithRelasi()
    {
        $this->model->insert([
            'nama_produk' => 'Produk Relasi',
            'harga' => 10000,
            'stok' => 10,
            'id_kategori' => $this->kategori['id_kategori'],
            'id_supplier' => $this->supplier['id_supplier'],
        ]);

        $result = $this->model->getAllWithRelasi();

        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('nama_kategori', $result[0]);
        $this->assertArrayHasKey('nama_supplier', $result[0]);
    }
}