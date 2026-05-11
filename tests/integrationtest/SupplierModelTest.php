<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\SupplierModel;

class SupplierModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;

    protected $existingDetailTransaksi = [];
    protected $existingProduk = [];
    protected $existingSupplier = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db    = \Config\Database::connect();
        $this->model = new SupplierModel();

        // Backup data asli
        $this->existingDetailTransaksi = $this->db->table('detail_transaksi')->get()->getResultArray();
        $this->existingProduk          = $this->db->table('produk')->get()->getResultArray();
        $this->existingSupplier        = $this->db->table('supplier')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('produk')->truncate();
        $this->db->table('supplier')->truncate();

        // Restore data asli
        if (!empty($this->existingSupplier))        $this->db->table('supplier')->insertBatch($this->existingSupplier);
        if (!empty($this->existingProduk))          $this->db->table('produk')->insertBatch($this->existingProduk);
        if (!empty($this->existingDetailTransaksi)) $this->db->table('detail_transaksi')->insertBatch($this->existingDetailTransaksi);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertSupplierValid()
    {
        $result = $this->model->insert(['nama_supplier' => 'Supplier A', 'no_telp' => '08123456789']);
        $this->assertNotFalse($result);
    }

    public function testInsertSupplierNamaKosong()
    {
        $result = $this->model->insert(['nama_supplier' => '', 'no_telp' => '08123456789']);
        $this->assertFalse($result);
    }

    public function testInsertSupplierNoTelpKosong()
    {
        $result = $this->model->insert(['nama_supplier' => 'Supplier B', 'no_telp' => '']);
        $this->assertFalse($result);
    }

    public function testFindSupplier()
    {
        $this->model->insert(['nama_supplier' => 'Supplier C', 'no_telp' => '0811111111']);
        $result = $this->model->where('nama_supplier', 'Supplier C')->first();
        $this->assertNotNull($result);
        $this->assertEquals('Supplier C', $result['nama_supplier']);
    }
}