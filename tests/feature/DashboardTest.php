<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class DashboardTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected $existingDetailTransaksi = [];
    protected $existingTransaksi = [];
    protected $existingStokMasuk = [];
    protected $existingProduk = [];
    protected $existingSupplier = [];
    protected $existingKategori = [];
    protected $existingUsers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        // Backup data asli
        $this->existingDetailTransaksi = $this->db->table('detail_transaksi')->get()->getResultArray();
        $this->existingTransaksi       = $this->db->table('transaksi')->get()->getResultArray();
        $this->existingStokMasuk       = $this->db->table('stok_masuk')->get()->getResultArray();
        $this->existingProduk          = $this->db->table('produk')->get()->getResultArray();
        $this->existingSupplier        = $this->db->table('supplier')->get()->getResultArray();
        $this->existingKategori        = $this->db->table('kategori')->get()->getResultArray();
        $this->existingUsers           = $this->db->table('users')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Insert data dummy
        $this->db->table('users')->insert([
            'username' => 'admin_test',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);
        $userId = $this->db->insertID();

        $this->db->table('kategori')->insert(['nama_kategori' => 'Makanan']);
        $kategoriId = $this->db->insertID();

        $this->db->table('supplier')->insert(['nama_supplier' => 'Supplier Test', 'no_telp' => '08123']);
        $supplierId = $this->db->insertID();

        $this->db->table('produk')->insert([
            'nama_produk' => 'Whiskas',
            'harga'       => 10000,
            'stok'        => 20,
            'id_kategori' => $kategoriId,
            'id_supplier' => $supplierId,
        ]);
        $produkId = $this->db->insertID();

        $this->db->table('transaksi')->insert([
            'id_user' => $userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 50000,
        ]);

        $this->db->table('stok_masuk')->insert([
            'id_produk'   => $produkId,
            'id_supplier' => $supplierId,
            'jumlah'      => 5,
            'tanggal'     => date('Y-m-d'),
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

        // Restore data asli
        if (!empty($this->existingUsers))           $this->db->table('users')->insertBatch($this->existingUsers);
        if (!empty($this->existingKategori))        $this->db->table('kategori')->insertBatch($this->existingKategori);
        if (!empty($this->existingSupplier))        $this->db->table('supplier')->insertBatch($this->existingSupplier);
        if (!empty($this->existingProduk))          $this->db->table('produk')->insertBatch($this->existingProduk);
        if (!empty($this->existingStokMasuk))       $this->db->table('stok_masuk')->insertBatch($this->existingStokMasuk);
        if (!empty($this->existingTransaksi))       $this->db->table('transaksi')->insertBatch($this->existingTransaksi);
        if (!empty($this->existingDetailTransaksi)) $this->db->table('detail_transaksi')->insertBatch($this->existingDetailTransaksi);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testDashboardRedirectJikaBelumLogin()
    {
        $result = $this->get('/dashboard');
        $result->assertRedirectTo('/login');
    }

    public function testDashboardBerhasilDiaksesSaatLogin()
    {
        $result = $this->withSession(['logged_in' => true, 'username' => 'admin_test'])->get('/dashboard');
        $result->assertStatus(200);
    }

    public function testDashboardMenampilkanData()
    {
        $result = $this->withSession(['logged_in' => true, 'username' => 'admin_test'])->get('/dashboard');
        $result->assertStatus(200);
        $result->assertSee('Momo Petshop');
        $result->assertSee('admin_test');
    }
}