<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class TransaksiTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected $kategoriId;
    protected $supplierId;
    protected $produkId;
    protected $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();

        // Disable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Reset tabel
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();

        // Enable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // =========================
        // INSERT DATA DUMMY
        // =========================

        // kategori
        $this->db->table('kategori')->insert([
            'nama_kategori' => 'Makanan'
        ]);

        $this->kategoriId = $this->db->insertID();

        // supplier
        $this->db->table('supplier')->insert([
            'nama_supplier' => 'Supplier Test',
            'no_telp'       => '08123456789'
        ]);

        $this->supplierId = $this->db->insertID();

        // produk
        $this->db->table('produk')->insert([
            'nama_produk' => 'Whiskas',
            'harga'       => 5000,
            'stok'        => 20,
            'id_kategori' => $this->kategoriId,
            'id_supplier' => $this->supplierId,
        ]);

        $this->produkId = $this->db->insertID();

        // user
        $this->db->table('users')->insert([
            'username' => 'kasir_test',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $this->userId = $this->db->insertID();
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

    // =====================================
    // TEST HALAMAN LIST TRANSAKSI
    // =====================================
    public function testHalamanTransaksi()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->get('/transaksi');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST HALAMAN TAMBAH TRANSAKSI
    // =====================================
    public function testHalamanTambahTransaksi()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->get('/transaksi/tambah');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST SIMPAN TRANSAKSI
    // =====================================
    public function testSimpanTransaksi()
    {
        $postData = [
            'tanggal'   => date('Y-m-d'),
            'total'     => 10000,
            'id_produk' => [$this->produkId],
            'qty'       => [2],
            'harga'     => [5000],
        ];

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->post('/transaksi/simpan', $postData);

        $result->assertRedirectTo('/transaksi');

        // cek transaksi masuk
        $transaksi = $this->db->table('transaksi')->get()->getResultArray();

        $this->assertCount(1, $transaksi);

        // cek detail transaksi masuk
        $detail = $this->db->table('detail_transaksi')->get()->getResultArray();

        $this->assertCount(1, $detail);

        // cek stok produk berkurang
        $produk = $this->db->table('produk')
            ->where('id_produk', $this->produkId)
            ->get()
            ->getRowArray();

        $this->assertEquals(18, $produk['stok']);
    }

    // =====================================
    // TEST DETAIL TRANSAKSI
    // =====================================
    public function testDetailTransaksi()
    {
        // insert transaksi
        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 10000,
        ]);

        $idTransaksi = $this->db->insertID();

        // insert detail
        $this->db->table('detail_transaksi')->insert([
            'id_transaksi' => $idTransaksi,
            'id_produk'    => $this->produkId,
            'qty'          => 2,
            'harga'        => 5000,
            'subtotal'     => 10000,
        ]);

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->get('/transaksi/detail/' . $idTransaksi);

        $result->assertStatus(200);

        $json = json_decode($result->getJSON(), true);

        $this->assertEquals(10000, $json['transaksi']['total']);
    }

    // =====================================
    // TEST GAGAL SIMPAN TRANSAKSI
    // =====================================
    public function testSimpanTransaksiGagal()
    {
        $postData = [
            'tanggal' => '',
            'total'   => 0,
        ];

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->post('/transaksi/simpan', $postData);

        $result->assertStatus(302);
    }
}