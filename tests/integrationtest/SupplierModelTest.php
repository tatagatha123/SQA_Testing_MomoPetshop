<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\SupplierModel;

class SupplierModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new SupplierModel();

        // Disable foreign key sementara
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Bersihin tabel (child dulu)
        $this->db->table('detail_transaksi')->emptyTable();
        $this->db->table('produk')->emptyTable();
        $this->db->table('supplier')->emptyTable();

        // Enable lagi
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $this->db->table('detail_transaksi')->emptyTable();
        $this->db->table('produk')->emptyTable();
        $this->db->table('supplier')->emptyTable();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertSupplierValid()
    {
        $result = $this->model->insert([
            'nama_supplier' => 'Supplier A',
            'no_telp' => '08123456789'
        ]);

        $this->assertNotFalse($result);
    }

    public function testInsertSupplierNamaKosong()
    {
        $result = $this->model->insert([
            'nama_supplier' => '',
            'no_telp' => '08123456789'
        ]);

        $this->assertFalse($result);
    }

    public function testInsertSupplierNoTelpKosong()
    {
        $result = $this->model->insert([
            'nama_supplier' => 'Supplier B',
            'no_telp' => ''
        ]);

        $this->assertFalse($result);
    }

    public function testFindSupplier()
    {
        $this->model->insert([
            'nama_supplier' => 'Supplier C',
            'no_telp' => '0811111111'
        ]);

        $result = $this->model
            ->where('nama_supplier', 'Supplier C')
            ->first();

        $this->assertNotNull($result);
        $this->assertEquals('Supplier C', $result['nama_supplier']);
    }
}