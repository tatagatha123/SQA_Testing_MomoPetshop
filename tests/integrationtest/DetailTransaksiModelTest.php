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

        // =========================
        // USER TEST
        // =========================
        $user = $this->db->table('users')
            ->where('username', 'kasir_test')
            ->get()
            ->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'kasir_test',
                'password' => password_hash(
                    '123',
                    PASSWORD_DEFAULT
                ),
            ]);

            $this->userId = $this->db->insertID();
        } else {
            $this->userId = $user['id_user'];
        }

        // =========================
        // TRANSAKSI TEST
        // =========================
        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 1000
        ]);

        $this->transaksiId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus detail transaksi test
        $this->db->table('detail_transaksi')
            ->where('id_transaksi', $this->transaksiId)
            ->delete();

        // hapus transaksi test
        $this->db->table('transaksi')
            ->where('id_transaksi', $this->transaksiId)
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

        // hapus user test
        $this->db->table('users')
            ->where('username', 'kasir_test')
            ->delete();
    }

    // ===============================
    // TEST INSERT SINGLE
    // ===============================
    public function testInsertDetail()
    {
        $result = $this->model->insert([
            'id_transaksi' => $this->transaksiId,
            'id_produk'    => $this->produkId,
            'qty'          => 2,
            'harga'        => 1000,
            'subtotal'     => 2000
        ]);

        $this->assertNotFalse($result);
    }

    // ===============================
    // TEST GET BY TRANSAKSI
    // ===============================
    public function testGetByTransaksi()
    {
        $this->model->insert([
            'id_transaksi' => $this->transaksiId,
            'id_produk'    => $this->produkId,
            'qty'          => 1,
            'harga'        => 1000,
            'subtotal'     => 1000
        ]);

        $result = $this->model->getByTransaksi(
            $this->transaksiId
        );

        $this->assertCount(1, $result);

        $this->assertEquals(
            'TEST_PRODUK',
            $result[0]['nama_produk']
        );
    }

    // ===============================
    // TEST INSERT BATCH
    // ===============================
    public function testSimpanBatch()
    {
        $data = [
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk'    => $this->produkId,
                'qty'          => 1,
                'harga'        => 1000,
                'subtotal'     => 1000
            ],
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk'    => $this->produkId,
                'qty'          => 2,
                'harga'        => 1000,
                'subtotal'     => 2000
            ]
        ];

        $result = $this->model->simpanBatch($data);

        $this->assertTrue($result);
    }

    // ===============================
    // TEST TOTAL SUBTOTAL
    // ===============================
    public function testTotalSubtotalBatch()
    {
        $data = [
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk'    => $this->produkId,
                'qty'          => 1,
                'harga'        => 1000,
                'subtotal'     => 1000
            ],
            [
                'id_transaksi' => $this->transaksiId,
                'id_produk'    => $this->produkId,
                'qty'          => 3,
                'harga'        => 1000,
                'subtotal'     => 3000
            ]
        ];

        $this->model->simpanBatch($data);

        $result = $this->model
            ->where('id_transaksi', $this->transaksiId)
            ->findAll();

        $totalSubtotal = array_sum(
            array_column($result, 'subtotal')
        );

        $this->assertEquals(4000, $totalSubtotal);
    }
}