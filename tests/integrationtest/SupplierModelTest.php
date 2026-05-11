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
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus hanya data testing
        $this->db->table('supplier')
            ->whereIn('nama_supplier', [
                'Supplier A',
                'Supplier B',
                'Supplier C'
            ])
            ->delete();
    }

    // =====================================
    // TEST INSERT VALID
    // =====================================
    public function testInsertSupplierValid()
    {
        $result = $this->model->insert([
            'nama_supplier' => 'Supplier A',
            'no_telp'       => '08123456789'
        ]);

        $this->assertNotFalse($result);
    }

    // =====================================
    // TEST NAMA KOSONG
    // =====================================
    public function testInsertSupplierNamaKosong()
    {
        $result = $this->model->insert([
            'nama_supplier' => '',
            'no_telp'       => '08123456789'
        ]);

        $this->assertFalse($result);
    }

    // =====================================
    // TEST NO TELP KOSONG
    // =====================================
    public function testInsertSupplierNoTelpKosong()
    {
        $result = $this->model->insert([
            'nama_supplier' => 'Supplier B',
            'no_telp'       => ''
        ]);

        $this->assertFalse($result);
    }

    // =====================================
    // TEST FIND SUPPLIER
    // =====================================
    public function testFindSupplier()
    {
        $this->model->insert([
            'nama_supplier' => 'Supplier C',
            'no_telp'       => '0811111111'
        ]);

        $result = $this->model
            ->where('nama_supplier', 'Supplier C')
            ->first();

        $this->assertNotNull($result);

        $this->assertEquals(
            'Supplier C',
            $result['nama_supplier']
        );
    }
}