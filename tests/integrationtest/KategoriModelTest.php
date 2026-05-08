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

        // reset tabel
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('kategori')->emptyTable();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('kategori')->emptyTable();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    // TEST INSERT VALID
    public function testInsertKategoriValid()
    {
        $result = $this->model->insert([
            'nama_kategori' => 'Makanan Kucing'
        ]);

        $this->assertNotFalse($result);
    }

    // TEST NAMA KOSONG
    public function testInsertKategoriKosong()
    {
        $result = $this->model->insert([
            'nama_kategori' => ''
        ]);

        $this->assertFalse($result);
    }

    // TEST TERLALU PENDEK
    public function testInsertKategoriTerlaluPendek()
    {
        $result = $this->model->insert([
            'nama_kategori' => 'A'
        ]);

        $this->assertFalse($result);
    }

    // TEST FIND DATA
    public function testFindKategori()
    {
        $this->model->insert([
            'nama_kategori' => 'Obat'
        ]);

        $result = $this->model
            ->where('nama_kategori', 'Obat')
            ->first();

        $this->assertNotNull($result);
        $this->assertEquals('Obat', $result['nama_kategori']);
    }

    // TEST DROPDOWN (JUMLAH + SORTING)
    public function testGetForDropdown()
    {
        // sengaja tidak urut untuk ngetes sorting
        $this->model->insert(['nama_kategori' => 'Vitamin']);
        $this->model->insert(['nama_kategori' => 'Aksesoris']);

        $result = $this->model->getForDropdown();

        $this->assertCount(2, $result);

        // cek urutan ASC
        $this->assertEquals('Aksesoris', $result[0]['nama_kategori']);
        $this->assertEquals('Vitamin', $result[1]['nama_kategori']);
    }
}