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

        // disable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        // reset tabel
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();

        // enable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // =========================
        // INSERT DATA DUMMY
        // =========================

        // user
        $this->db->table('users')->insert([
            'username' => 'admin_test',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $userId = $this->db->insertID();

        // kategori
        $this->db->table('kategori')->insert([
            'nama_kategori' => 'Makanan'
        ]);

        $kategoriId = $this->db->insertID();

        // supplier
        $this->db->table('supplier')->insert([
            'nama_supplier' => 'Supplier Test',
            'no_telp' => '08123'
        ]);

        $supplierId = $this->db->insertID();

        // produk
        $this->db->table('produk')->insert([
            'nama_produk' => 'Whiskas',
            'harga' => 10000,
            'stok' => 20,
            'id_kategori' => $kategoriId,
            'id_supplier' => $supplierId
        ]);

        $produkId = $this->db->insertID();

        // transaksi
        $this->db->table('transaksi')->insert([
            'id_user' => $userId,
            'tanggal' => date('Y-m-d'),
            'total' => 50000
        ]);

        // stok masuk
        $this->db->table('stok_masuk')->insert([
            'id_produk' => $produkId,
            'id_supplier' => $supplierId,
            'jumlah' => 5,
            'tanggal' => date('Y-m-d')
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
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