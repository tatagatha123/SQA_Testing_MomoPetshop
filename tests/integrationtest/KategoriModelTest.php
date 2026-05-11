<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\KategoriModel;

class KategoriModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new KategoriModel();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus hanya data testing
        $this->db->table('kategori')
            ->whereIn('nama_kategori', [
                'Makanan Kucing',
                'Obat',
                'Vitamin',
                'Aksesoris',
                'A'
            ])
            ->delete();
    }

    // =====================================
    // TEST INSERT VALID
    // =====================================
    public function testInsertKategoriValid()
    {
        $result = $this->model->insert([
            'nama_kategori' => 'Makanan Kucing'
        ]);

        $this->assertNotFalse($result);
    }

    // =====================================
    // TEST NAMA KOSONG
    // =====================================
    public function testInsertKategoriKosong()
    {
        $result = $this->model->insert([
            'nama_kategori' => ''
        ]);

        $this->assertFalse($result);
    }

    // =====================================
    // TEST TERLALU PENDEK
    // =====================================
    public function testInsertKategoriTerlaluPendek()
    {
        $result = $this->model->insert([
            'nama_kategori' => 'A'
        ]);

        $this->assertFalse($result);
    }

    // =====================================
    // TEST FIND DATA
    // =====================================
    public function testFindKategori()
    {
        $this->model->insert([
            'nama_kategori' => 'Obat'
        ]);

        $result = $this->model
            ->where('nama_kategori', 'Obat')
            ->first();

        $this->assertNotNull($result);

        $this->assertEquals(
            'Obat',
            $result['nama_kategori']
        );
    }

    // =====================================
    // TEST DROPDOWN
    // =====================================
    public function testGetForDropdown()
    {
        $this->model->insert([
            'nama_kategori' => 'Vitamin'
        ]);

        $this->model->insert([
            'nama_kategori' => 'Aksesoris'
        ]);

        $result = $this->model->getForDropdown();

        $this->assertGreaterThanOrEqual(
            2,
            count($result)
        );
    }
}