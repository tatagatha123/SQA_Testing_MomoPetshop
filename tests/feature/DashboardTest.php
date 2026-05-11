<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class DashboardTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        // =========================
        // USER TEST
        // =========================
        $user = $this->db->table('users')
            ->where('username', 'admin_test')
            ->get()
            ->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'admin_test',
                'password' => password_hash(
                    '123456',
                    PASSWORD_DEFAULT
                ),
            ]);

            $userId = $this->db->insertID();
        } else {
            $userId = $user['id_user'];
        }

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

            $kategoriId = $this->db->insertID();
        } else {
            $kategoriId = $kategori['id_kategori'];
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
                'no_telp'       => '08123'
            ]);

            $supplierId = $this->db->insertID();
        } else {
            $supplierId = $supplier['id_supplier'];
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
                'harga'       => 10000,
                'stok'        => 20,
                'id_kategori' => $kategoriId,
                'id_supplier' => $supplierId
            ]);

            $produkId = $this->db->insertID();
        } else {
            $produkId = $produk['id_produk'];
        }

        // =========================
        // TRANSAKSI TEST
        // =========================
        $this->db->table('transaksi')->insert([
            'id_user' => $userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 50000
        ]);

        // =========================
        // STOK MASUK TEST
        // =========================
        $this->db->table('stok_masuk')->insert([
            'id_produk'   => $produkId,
            'id_supplier' => $supplierId,
            'jumlah'      => 5,
            'tanggal'     => date('Y-m-d')
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus hanya data testing
        $this->db->table('stok_masuk')
            ->where('jumlah', 5)
            ->delete();

        $this->db->table('transaksi')
            ->where('total', 50000)
            ->delete();

        $this->db->table('produk')
            ->where('nama_produk', 'Whiskas Test')
            ->delete();

        $this->db->table('supplier')
            ->where('nama_supplier', 'Supplier Test')
            ->delete();

        $this->db->table('kategori')
            ->where('nama_kategori', 'Kategori Test')
            ->delete();

        $this->db->table('users')
            ->where('username', 'admin_test')
            ->delete();
    }

    // =====================================
    // TEST REDIRECT JIKA BELUM LOGIN
    // =====================================
    public function testDashboardRedirectJikaBelumLogin()
    {
        $result = $this->get('/dashboard');

        $result->assertRedirectTo('/login');
    }

    // =====================================
    // TEST DASHBOARD BERHASIL DIAKSES
    // =====================================
    public function testDashboardBerhasilDiaksesSaatLogin()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'username'  => 'admin_test'
        ])->get('/dashboard');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST DASHBOARD MENAMPILKAN DATA
    // =====================================
    public function testDashboardMenampilkanData()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'username'  => 'admin_test'
        ])->get('/dashboard');

        $result->assertStatus(200);

        $result->assertSee('Momo Petshop');
        $result->assertSee('admin_test');
    }
}