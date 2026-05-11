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

        // ===============================
        // KATEGORI TEST
        // ===============================
        $kategori = $this->db->table('kategori')
            ->where('nama_kategori', 'TEST KATEGORI')
            ->get()
            ->getRowArray();

        if (!$kategori) {
            $this->db->table('kategori')->insert([
                'nama_kategori' => 'TEST KATEGORI'
            ]);

            $this->kategoriId = $this->db->insertID();
        } else {
            $this->kategoriId = $kategori['id_kategori'];
        }

        // ===============================
        // SUPPLIER TEST
        // ===============================
        $supplier = $this->db->table('supplier')
            ->where('nama_supplier', 'TEST SUPPLIER')
            ->get()
            ->getRowArray();

        if (!$supplier) {
            $this->db->table('supplier')->insert([
                'nama_supplier' => 'TEST SUPPLIER',
                'no_telp'       => '08123'
            ]);

            $this->supplierId = $this->db->insertID();
        } else {
            $this->supplierId = $supplier['id_supplier'];
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
            ->whereIn('nama_produk', [
                'Whiskas',
                'TEST'
            ])
            ->delete();

        // hapus kategori test
        $this->db->table('kategori')
            ->where('nama_kategori', 'TEST KATEGORI')
            ->delete();

        // hapus supplier test
        $this->db->table('supplier')
            ->where('nama_supplier', 'TEST SUPPLIER')
            ->delete();
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
                'harga'       => 10000,
                'stok'        => 5,
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
                'harga'       => '',
                'stok'        => '',
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
            'harga'       => 1000,
            'stok'        => 2,
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