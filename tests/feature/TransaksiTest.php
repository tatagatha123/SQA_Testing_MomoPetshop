<?php

namespace Tests\Feature;

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

        // =========================
        // KATEGORI TEST
        // =========================
        $kategori = $this->db->table('kategori')
            ->where('nama_kategori', 'Makanan Test')
            ->get()
            ->getRowArray();

        if (!$kategori) {
            $this->db->table('kategori')->insert([
                'nama_kategori' => 'Makanan Test'
            ]);

            $this->kategoriId = $this->db->insertID();
        } else {
            $this->kategoriId = $kategori['id_kategori'];
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
                'nama_supplier' => 'Supplier Test',
                'no_telp'       => '08123456789'
            ]);

            $this->supplierId = $this->db->insertID();
        } else {
            $this->supplierId = $supplier['id_supplier'];
        }

        // =========================
        // PRODUK TEST
        // =========================
        $produk = $this->db->table('produk')
            ->where('nama_produk', 'Whiskas Test')
            ->get()
            ->getRowArray();

        if (!$produk) {
            $this->db->table('produk')->insert([
                'nama_produk' => 'Whiskas Test',
                'harga'       => 5000,
                'stok'        => 20,
                'id_kategori' => $this->kategoriId,
                'id_supplier' => $this->supplierId,
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
                    '123456',
                    PASSWORD_DEFAULT
                ),
            ]);

            $this->userId = $this->db->insertID();
        } else {
            $this->userId = $user['id_user'];
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus detail transaksi test
        $this->db->table('detail_transaksi')
        ->where('1 = 1')
        ->delete();

        // hapus transaksi test
        $this->db->table('transaksi')
            ->where('total', 10000)
            ->delete();

        // hapus produk test
        $this->db->table('produk')
            ->where('nama_produk', 'Whiskas Test')
            ->delete();

        // hapus supplier test
        $this->db->table('supplier')
            ->where('nama_supplier', 'Supplier Test')
            ->delete();

        // hapus kategori test
        $this->db->table('kategori')
            ->where('nama_kategori', 'Makanan Test')
            ->delete();

        // hapus user test
        $this->db->table('users')
            ->where('username', 'kasir_test')
            ->delete();
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
    }

    // =====================================
    // TEST DETAIL TRANSAKSI
    // =====================================
    public function testDetailTransaksi()
    {
        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 10000,
        ]);

        $idTransaksi = $this->db->insertID();

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