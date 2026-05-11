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

    protected $existingDetailTransaksi = [];
    protected $existingTransaksi = [];
    protected $existingProduk = [];
    protected $existingSupplier = [];
    protected $existingKategori = [];
    protected $existingUsers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();

        // Backup data asli
        $this->existingDetailTransaksi = $this->db->table('detail_transaksi')->get()->getResultArray();
        $this->existingTransaksi       = $this->db->table('transaksi')->get()->getResultArray();
        $this->existingProduk          = $this->db->table('produk')->get()->getResultArray();
        $this->existingSupplier        = $this->db->table('supplier')->get()->getResultArray();
        $this->existingKategori        = $this->db->table('kategori')->get()->getResultArray();
        $this->existingUsers           = $this->db->table('users')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->table('kategori')->truncate();
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // Insert data dummy
        $this->db->table('kategori')->insert(['nama_kategori' => 'Makanan']);
        $this->kategoriId = $this->db->insertID();

        $this->db->table('supplier')->insert(['nama_supplier' => 'Supplier Test', 'no_telp' => '08123456789']);
        $this->supplierId = $this->db->insertID();

        $this->db->table('produk')->insert([
            'nama_produk' => 'Whiskas',
            'harga'       => 5000,
            'stok'        => 20,
            'id_kategori' => $this->kategoriId,
            'id_supplier' => $this->supplierId,
        ]);
        $this->produkId = $this->db->insertID();

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

        // Restore data asli
        if (!empty($this->existingUsers))           $this->db->table('users')->insertBatch($this->existingUsers);
        if (!empty($this->existingKategori))        $this->db->table('kategori')->insertBatch($this->existingKategori);
        if (!empty($this->existingSupplier))        $this->db->table('supplier')->insertBatch($this->existingSupplier);
        if (!empty($this->existingProduk))          $this->db->table('produk')->insertBatch($this->existingProduk);
        if (!empty($this->existingTransaksi))       $this->db->table('transaksi')->insertBatch($this->existingTransaksi);
        if (!empty($this->existingDetailTransaksi)) $this->db->table('detail_transaksi')->insertBatch($this->existingDetailTransaksi);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testHalamanTransaksi()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])->get('/transaksi');
        $result->assertStatus(200);
    }

    public function testHalamanTambahTransaksi()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])->get('/transaksi/tambah');
        $result->assertStatus(200);
    }

    public function testSimpanTransaksi()
    {
        $postData = [
            'tanggal'   => date('Y-m-d'),
            'total'     => 10000,
            'id_produk' => [$this->produkId],
            'qty'       => [2],
            'harga'     => [5000],
        ];

        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])
            ->post('/transaksi/simpan', $postData);
        $result->assertRedirectTo('/transaksi');

        $transaksi = $this->db->table('transaksi')->get()->getResultArray();
        $this->assertCount(1, $transaksi);

        $detail = $this->db->table('detail_transaksi')->get()->getResultArray();
        $this->assertCount(1, $detail);

        $produk = $this->db->table('produk')->where('id_produk', $this->produkId)->get()->getRowArray();
        $this->assertEquals(18, $produk['stok']);
    }

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

        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])
            ->get('/transaksi/detail/' . $idTransaksi);
        $result->assertStatus(200);

        $json = json_decode($result->getJSON(), true);
        $this->assertEquals(10000, $json['transaksi']['total']);
    }

    public function testSimpanTransaksiGagal()
    {
        $postData = ['tanggal' => '', 'total' => 0];

        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])
            ->post('/transaksi/simpan', $postData);
        $result->assertStatus(302);
    }
}