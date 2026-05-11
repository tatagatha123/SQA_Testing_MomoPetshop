<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\TransaksiModel;

class TransaksiModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;
    protected $userId;

    protected $existingTransaksi = [];
    protected $existingUsers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db    = \Config\Database::connect();
        $this->model = new TransaksiModel();

        // Backup data asli
        $this->existingTransaksi = $this->db->table('transaksi')->get()->getResultArray();
        $this->existingUsers     = $this->db->table('users')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // Insert data dummy
        $this->db->table('users')->insert([
            'username' => 'kasir_test',
            'password' => password_hash('123', PASSWORD_DEFAULT),
        ]);
        $this->userId = $this->db->insertID();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();

        // Restore data asli
        if (!empty($this->existingUsers))     $this->db->table('users')->insertBatch($this->existingUsers);
        if (!empty($this->existingTransaksi)) $this->db->table('transaksi')->insertBatch($this->existingTransaksi);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testInsertTransaksi()
    {
        $result = $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 10000]);
        $this->assertNotFalse($result);
    }

    public function testGetAllTransaksi()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 5000]);
        $result = $this->model->getAllTransaksi();
        $this->assertCount(1, $result);
        $this->assertEquals(5000, $result[0]['total']);
    }

    public function testGetAllWithKasir()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 7000]);
        $result = $this->model->getAllWithKasir();
        $this->assertCount(1, $result);
        $this->assertEquals('kasir_test', $result[0]['kasir']);
        $this->assertEquals(7000, $result[0]['total']);
    }

    public function testGetById()
    {
        $id     = $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 8000]);
        $result = $this->model->getById($id);
        $this->assertNotNull($result);
        $this->assertEquals(8000, $result['total']);
    }

    public function testGetTotalPendapatan()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 1000]);
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 2000]);
        $total = $this->model->getTotalPendapatan();
        $this->assertEquals(3000, $total);
    }

    public function testGetCountHariIni()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 1000]);
        $count = $this->model->getCountHariIni();
        $this->assertEquals(1, $count);
    }

    public function testGetRecentHariIni()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 1500]);
        $result = $this->model->getRecentHariIni(5);
        $this->assertCount(1, $result);
        $this->assertEquals('kasir_test', $result[0]['kasir']);
        $this->assertEquals(1500, $result[0]['total']);
    }

    public function testGetAllTransaksiSorting()
    {
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => '2024-01-01', 'total' => 1000]);
        $this->model->insert(['id_user' => $this->userId, 'tanggal' => '2024-12-31', 'total' => 2000]);
        $result = $this->model->getAllTransaksi();
        $this->assertEquals(2000, $result[0]['total']);
    }
}