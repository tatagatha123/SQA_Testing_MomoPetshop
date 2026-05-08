<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\DetailTransaksiModel;

class DetailTransaksiModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;

    protected $kategoriId;
    protected $supplierId;
    protected $produkId;
    protected $userId;
    protected $transaksiId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new DetailTransaksiModel();

        // disable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // reset tabel
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();

        // enable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // ===== INSERT DATA RELASI =====

        // kategori
        $this->db->table('kategori')->insert([
            'nama_kategori' => 'TEST_KATEGORI'
        ]);
        $this->kategoriId = $this->db->insertID();

        // supplier
        $this->db->table('supplier')->insert([
            'nama_supplier' => 'TEST_SUPPLIER',
            'no_telp' => '08123'
        ]);
        $this->supplierId = $this->db->insertID();

        // produk
        $this->db->table('produk')->insert([
            'nama_produk' => 'TEST_PRODUK',
            'harga' => 1000,
            'stok' => 10,
            'id_kategori' => $this->kategoriId,
            'id_supplier' => $this->supplierId
        ]);
        $this->produkId = $this->db->insertID();

        // user
        $this->db->table('users')->insert([
            'username' => 'kasir_test',
            'password' => password_hash('123', PASSWORD_DEFAULT),
        ]);
        $this->userId = $this->db->insertID();

        // transaksi
        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total' => 1000
        ]);
        $this->transaksiId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    // ===============================
    // TEST INSERT SINGLE
    // ===============================
    public function testInsertDetail()
    {
        $result = $this->model->insert([
            'id_transaksi' => $this->transaksiId,
            'id_produk' => $this->produkId,
            'qty' => 2,
            'harga' => 1000,
            'subtotal' => 2000
        ]);

        $this->assertNotFalse($result);
    }

    // ===============================
    // TEST GET BY TRANSAKSI (JOIN)
    // ===============================
    public function testGetByTransaksi()
    {
        $this->model->insert([
            'id_transaksi' => $this->transaksiId,
            'id_produk' => $this->produkId,
            'qty' => 1,
            'harga' => 1000,
            'subtotal' => 1000
        ]);

        $result = $this->model->getByTransaksi($this->transaksiId);

        $this->assertCount(1, $result);
        $this->assertEquals('TEST_PRODUK', $result[0]['nama_produk']);
        $this->assertEquals(1, $result[0]['qty']);
        $this->assertEquals(1000, $result[0]['subtotal']);
    }

    // ===============================
    // TEST INSERT BATCH
    // ===============================
    public function testSimpanBatch()
    {
        $data = [
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk' => $this->produkId,
                'qty' => 1,
                'harga' => 1000,
                'subtotal' => 1000
            ],
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk' => $this->produkId,
                'qty' => 2,
                'harga' => 1000,
                'subtotal' => 2000
            ]
        ];

        $result = $this->model->simpanBatch($data);

        $this->assertTrue($result);

        $all = $this->model
            ->where('id_transaksi', $this->transaksiId)
            ->findAll();

        $this->assertCount(2, $all);
    }

    // ===============================
    // TEST TOTAL SUBTOTAL BATCH
    // ===============================
    public function testTotalSubtotalBatch()
    {
        $data = [
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk' => $this->produkId,
                'qty' => 1,
                'harga' => 1000,
                'subtotal' => 1000
            ],
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk' => $this->produkId,
                'qty' => 3,
                'harga' => 1000,
                'subtotal' => 3000
            ]
        ];

        $this->model->simpanBatch($data);

        $result = $this->model
            ->where('id_transaksi', $this->transaksiId)
            ->findAll();

        $totalSubtotal = array_sum(array_column($result, 'subtotal'));

        $this->assertEquals(4000, $totalSubtotal);
    }
}