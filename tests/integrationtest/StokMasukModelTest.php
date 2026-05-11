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

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new StokMasukModel();

        // =========================
        // KATEGORI TEST
        // =========================
        $kategori = $this->db->table('kategori')
            ->where('nama_kategori', 'TEST_KATEGORI')
            ->get()
            ->getRowArray();

        if (!$kategori) {
            $this->db->table('kategori')->insert([
                'nama_kategori' => 'TEST_KATEGORI'
            ]);

            $this->kategoriId = $this->db->insertID();
        } else {
            $this->kategoriId = $kategori['id_kategori'];
        }

        // =========================
        // SUPPLIER TEST
        // =========================
        $supplier = $this->db->table('supplier')
            ->where('nama_supplier', 'TEST_SUPPLIER')
            ->get()
            ->getRowArray();

        if (!$supplier) {
            $this->db->table('supplier')->insert([
                'nama_supplier' => 'TEST_SUPPLIER',
                'no_telp'       => '08123'
            ]);

            $this->supplierId = $this->db->insertID();
        } else {
            $this->supplierId = $supplier['id_supplier'];
        }

        // =========================
        // PRODUK TEST
        // =========================
        $produk = $this->db->table('produk')
            ->where('nama_produk', 'TEST_PRODUK')
            ->get()
            ->getRowArray();

        if (!$produk) {
            $this->db->table('produk')->insert([
                'nama_produk' => 'TEST_PRODUK',
                'harga'       => 1000,
                'stok'        => 10,
                'id_kategori' => $this->kategoriId,
                'id_supplier' => $this->supplierId
            ]);

            $this->produkId = $this->db->insertID();
        } else {
            $this->produkId = $produk['id_produk'];
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus stok masuk test
        $this->db->table('stok_masuk')
        ->where('jumlah >', -1)
        ->delete();

        // hapus produk test
        $this->db->table('produk')
            ->where('nama_produk', 'TEST_PRODUK')
            ->delete();

        // hapus supplier test
        $this->db->table('supplier')
            ->where('nama_supplier', 'TEST_SUPPLIER')
            ->delete();

        // hapus kategori test
        $this->db->table('kategori')
            ->where('nama_kategori', 'TEST_KATEGORI')
            ->delete();
    }

    // =====================================
    // TEST INSERT VALID
    // =====================================
    public function testInsertStokMasuk()
    {
        $result = $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 5,
            'tanggal'     => date('Y-m-d')
        ]);

        $this->assertNotFalse($result);
    }

    // =====================================
    // TEST GET ALL + JOIN
    // =====================================
    public function testGetAllWithRelasi()
    {
        $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 10,
            'tanggal'     => date('Y-m-d')
        ]);

        $result = $this->model->getAllWithRelasi();

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST GET BY ID + JOIN
    // =====================================
    public function testGetByIdWithRelasi()
    {
        $id = $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 7,
            'tanggal'     => date('Y-m-d')
        ]);

        $result = $this->model->getByIdWithRelasi($id);

        $this->assertNotNull($result);

        $this->assertEquals(
            7,
            $result['jumlah']
        );
    }

    // =====================================
    // TEST RECENT STOK
    // =====================================
    public function testGetRecentStok()
    {
        $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 3,
            'tanggal'     => date('Y-m-d')
        ]);

        $result = $this->model->getRecentStok(1);

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST HARI INI
    // =====================================
    public function testGetRecentHariIni()
    {
        $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 8,
            'tanggal'     => date('Y-m-d')
        ]);

        $result = $this->model->getRecentHariIni(5);

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST TOTAL
    // =====================================
    public function testGetTotalStokMasuk()
    {
        $this->model->insert([
            'id_produk'   => $this->produkId,
            'id_supplier' => $this->supplierId,
            'jumlah'      => 2,
            'tanggal'     => date('Y-m-d')
        ]);

        $total = $this->model->getTotalStokMasuk();

        $this->assertGreaterThanOrEqual(1, $total);
    }

// =====================================
// TEST SORTING
// =====================================
public function testRecentStokSorting()
{
    $this->model->insert([
        'id_produk'   => $this->produkId,
        'id_supplier' => $this->supplierId,
        'jumlah'      => 1,
        'tanggal'     => '2024-01-01'
    ]);

    $this->model->insert([
        'id_produk'   => $this->produkId,
        'id_supplier' => $this->supplierId,
        'jumlah'      => 2,
        'tanggal'     => '2024-12-31'
    ]);

    $result = $this->model->getRecentStok(2);

    $this->assertNotEmpty($result);

    $this->assertGreaterThanOrEqual(
        1,
        count($result)
    );
}
}