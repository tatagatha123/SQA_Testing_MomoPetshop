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

        // =========================
        // KATEGORI TEST
        // =========================
        $kategori = $this->db->table('kategori')
            ->where('nama_kategori', 'Kategori Test')
            ->get()
            ->getRowArray();

        if (!$kategori) {
            $this->db->table('kategori')->insert([
                'nama_kategori' => 'Kategori Test'
            ]);

            $this->kategori = [
                'id_kategori' => $this->db->insertID()
            ];
        } else {
            $this->kategori = $kategori;
        }

        // =========================
        // SUPPLIER TEST
        // =========================
        $supplier = $this->db->table('supplier')
            ->where('nama_supplier', 'Supplier Test')
            ->get()
            ->getRowArray();

        if (!$supplier) {
            $this->db->table('supplier')->insert([
                'nama_supplier' => 'Supplier Test'
            ]);

            $this->supplier = [
                'id_supplier' => $this->db->insertID()
            ];
        } else {
            $this->supplier = $supplier;
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus produk testing
        $this->db->table('produk')
            ->whereIn('nama_produk', [
                'Makanan Kucing',
                'Produk Test',
                'Produk A',
                'Produk Low',
                'Produk Relasi'
            ])
            ->delete();

        // hapus kategori testing
        $this->db->table('kategori')
            ->where('nama_kategori', 'Kategori Test')
            ->delete();

        // hapus supplier testing
        $this->db->table('supplier')
            ->where('nama_supplier', 'Supplier Test')
            ->delete();
    }

    // =====================================
    // INSERT VALID
    // =====================================
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

    // =====================================
    // NAMA KOSONG
    // =====================================
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

    // =====================================
    // HARGA INVALID
    // =====================================
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

    // =====================================
    // STOK INVALID
    // =====================================
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

    // =====================================
    // GET ALL PRODUK
    // =====================================
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

        $this->assertNotEmpty($result);
    }

    // =====================================
    // STOK RENDAH
    // =====================================
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

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TOTAL PRODUK
    // =====================================
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

        $this->assertGreaterThanOrEqual(1, $total);
    }

    // =====================================
    // JOIN RELASI
    // =====================================
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
    }
}