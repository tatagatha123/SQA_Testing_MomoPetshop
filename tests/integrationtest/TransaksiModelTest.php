<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\TransaksiModel;

class TransaksiModelTest extends CIUnitTestCase
{
    protected $db;
    protected $model;
    protected $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();
        $this->model = new TransaksiModel();

        // =========================
        // USER TEST
        // =========================
        $user = $this->db->table('users')
            ->where('username', 'kasir_test')
            ->get()
            ->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'kasir_test',
                'password' => password_hash(
                    '123',
                    PASSWORD_DEFAULT
                ),
            ]);

            $this->userId = $this->db->insertID();
        } else {
            $this->userId = $user['id_user'];
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus transaksi test
        $this->db->table('transaksi')
            ->whereIn('total', [
                10000,
                5000,
                7000,
                8000,
                1000,
                2000,
                1500
            ])
            ->delete();

        // hapus user test
        $this->db->table('users')
            ->where('username', 'kasir_test')
            ->delete();
    }

    // =====================================
    // TEST INSERT
    // =====================================
    public function testInsertTransaksi()
    {
        $result = $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 10000
        ]);

        $this->assertNotFalse($result);
    }

    // =====================================
    // TEST GET ALL
    // =====================================
    public function testGetAllTransaksi()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 5000
        ]);

        $result = $this->model->getAllTransaksi();

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST JOIN USER
    // =====================================
    public function testGetAllWithKasir()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 7000
        ]);

        $result = $this->model->getAllWithKasir();

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST GET BY ID
    // =====================================
    public function testGetById()
    {
        $id = $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 8000
        ]);

        $result = $this->model->getById($id);

        $this->assertNotNull($result);

        $this->assertEquals(
            8000,
            $result['total']
        );
    }

    // =====================================
    // TEST TOTAL PENDAPATAN
    // =====================================
    public function testGetTotalPendapatan()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 1000
        ]);

        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 2000
        ]);

        $total = $this->model->getTotalPendapatan();

        $this->assertGreaterThanOrEqual(
            3000,
            $total
        );
    }

    // =====================================
    // TEST COUNT HARI INI
    // =====================================
    public function testGetCountHariIni()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 1000
        ]);

        $count = $this->model->getCountHariIni();

        $this->assertGreaterThanOrEqual(
            1,
            $count
        );
    }

    // =====================================
    // TEST RECENT HARI INI
    // =====================================
    public function testGetRecentHariIni()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 1500
        ]);

        $result = $this->model->getRecentHariIni(5);

        $this->assertNotEmpty($result);
    }

    // =====================================
    // TEST SORTING DESC
    // =====================================
    public function testGetAllTransaksiSorting()
    {
        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => '2024-01-01',
            'total'   => 1000
        ]);

        $this->model->insert([
            'id_user' => $this->userId,
            'tanggal' => '2024-12-31',
            'total'   => 2000
        ]);

        $result = $this->model->getAllTransaksi();

        $this->assertNotEmpty($result);
    }
}