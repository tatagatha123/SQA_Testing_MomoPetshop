<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class ProdukTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected $kategoriId;
    protected $supplierId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('supplier')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // kategori dummy
        $this->db->table('kategori')->insert([
            'nama_kategori' => 'TEST KATEGORI'
        ]);

        $this->kategoriId = $this->db->insertID();

        // supplier dummy
        $this->db->table('supplier')->insert([
            'nama_supplier' => 'TEST SUPPLIER',
            'no_telp' => '08123'
        ]);

        $this->supplierId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        $this->db->table('stok_masuk')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('supplier')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    // ===============================
    // TEST HALAMAN PRODUK
    // ===============================
    public function testIndexProduk()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
        ])->get('/produk');

        $result->assertStatus(200);
    }

    // ===============================
    // TEST HALAMAN TAMBAH
    // ===============================
    public function testTambahProduk()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
        ])->get('/produk/tambah');

        $result->assertStatus(200);
    }

    // ===============================
    // TEST STORE SUCCESS
    // ===============================
    public function testStoreProdukSuccess()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
        ])->withBodyFormat('json')
          ->post('/produk/store', [
                'nama_produk' => 'Whiskas',
                'harga' => 10000,
                'stok' => 5,
                'id_kategori' => $this->kategoriId,
                'id_supplier' => $this->supplierId,
            ]);

        $result->assertRedirectTo('/produk');
    }

    // ===============================
    // TEST VALIDASI GAGAL
    // ===============================
    public function testStoreProdukValidationFailed()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
        ])->withBodyFormat('json')
          ->post('/produk/store', [
                'nama_produk' => '',
                'harga' => '',
                'stok' => '',
                'id_kategori' => '',
                'id_supplier' => '',
            ]);

        $result->assertStatus(200);
    }

    // ===============================
    // TEST DELETE PRODUK
    // ===============================
    public function testDeleteProduk()
    {
        $this->db->table('produk')->insert([
            'nama_produk' => 'TEST',
            'harga' => 1000,
            'stok' => 2,
            'id_kategori' => $this->kategoriId,
            'id_supplier' => $this->supplierId,
        ]);

        $idProduk = $this->db->insertID();

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
        ])->get('/produk/delete/' . $idProduk);

        $result->assertRedirectTo('/produk');
    }
}