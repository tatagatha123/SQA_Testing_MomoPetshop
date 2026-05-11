<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class LaporanTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;
    protected $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();

        // =========================
        // CEK / INSERT USER TEST
        // =========================
        $user = $this->db->table('users')
            ->where('username', 'admin_test')
            ->get()
            ->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'admin_test',
                'password' => password_hash(
                    '123456',
                    PASSWORD_DEFAULT
                ),
            ]);

            $this->userId = $this->db->insertID();
        } else {
            $this->userId = $user['id_user'];
        }

        // =========================
        // INSERT TRANSAKSI TEST
        // =========================
        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 10000,
        ]);

        $this->db->table('transaksi')->insert([
            'id_user' => $this->userId,
            'tanggal' => date('Y-m-d'),
            'total'   => 20000,
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus transaksi testing saja
        $this->db->table('transaksi')
            ->whereIn('total', [10000, 20000])
            ->delete();

        // hapus user testing
        $this->db->table('users')
            ->where('username', 'admin_test')
            ->delete();
    }

    // =====================================
    // TEST HARUS LOGIN
    // =====================================
    public function testLaporanRedirectJikaBelumLogin()
    {
        $result = $this->get('/laporan');

        $result->assertStatus(302);
    }

    // =====================================
    // TEST HALAMAN LAPORAN
    // =====================================
    public function testHalamanLaporan()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->get('/laporan');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST DATA LAPORAN MUNCUL
    // =====================================
    public function testDataLaporanMuncul()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->userId,
        ])->get('/laporan');

        $result->assertStatus(200);

        $result->assertSee('10.000');
        $result->assertSee('20.000');
    }

    // =====================================
    // TEST TOTAL TRANSAKSI
    // =====================================
    public function testTotalTransaksi()
    {
        $count = $this->db->table('transaksi')
            ->where('id_user', $this->userId)
            ->countAllResults();

        $this->assertGreaterThanOrEqual(2, $count);
    }

    // =====================================
    // TEST TOTAL PENDAPATAN
    // =====================================
    public function testTotalPendapatan()
    {
        $total = $this->db->table('transaksi')
            ->selectSum('total')
            ->where('id_user', $this->userId)
            ->get()
            ->getRow()
            ->total;

        $this->assertGreaterThanOrEqual(30000, $total);
    }
}