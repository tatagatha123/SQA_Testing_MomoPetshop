<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\KategoriModel;

class KategoriModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;

    protected $existingKategori = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db    = \Config\Database::connect();
        $this->model = new KategoriModel();

        // Backup data asli
        $this->existingKategori = $this->db->table('kategori')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('kategori')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('kategori')->truncate();

        // Restore data asli
        if (!empty($this->existingKategori)) {
            $this->db->table('kategori')->insertBatch($this->existingKategori);
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertKategoriValid()
    {
        $result = $this->model->insert(['nama_kategori' => 'Makanan Kucing']);
        $this->assertNotFalse($result);
    }

    public function testInsertKategoriKosong()
    {
        $result = $this->model->insert(['nama_kategori' => '']);
        $this->assertFalse($result);
    }

    public function testInsertKategoriTerlaluPendek()
    {
        $result = $this->model->insert(['nama_kategori' => 'A']);
        $this->assertFalse($result);
    }

    public function testFindKategori()
    {
        $this->model->insert(['nama_kategori' => 'Obat']);
        $result = $this->model->where('nama_kategori', 'Obat')->first();
        $this->assertNotNull($result);
        $this->assertEquals('Obat', $result['nama_kategori']);
    }

    public function testGetForDropdown()
    {
        $this->model->insert(['nama_kategori' => 'Vitamin']);
        $this->model->insert(['nama_kategori' => 'Aksesoris']);

        $result = $this->model->getForDropdown();

        $this->assertCount(2, $result);
        $this->assertEquals('Aksesoris', $result[0]['nama_kategori']);
        $this->assertEquals('Vitamin', $result[1]['nama_kategori']);
    }
}