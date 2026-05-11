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

        // disable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // reset tabel
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();

        // enable FK
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // =========================
        // INSERT USER
        // =========================
        $this->db->table('users')->insert([
            'username' => 'admin_test',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $this->userId = $this->db->insertID();

        // =========================
        // INSERT TRANSAKSI
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

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
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

        // cek total transaksi tampil
        $result->assertSee('10.000');
        $result->assertSee('20.000');
    }

    // =====================================
    // TEST TOTAL TRANSAKSI
    // =====================================
    public function testTotalTransaksi()
    {
        $count = $this->db->table('transaksi')->countAll();

        $this->assertEquals(2, $count);
    }

    // =====================================
    // TEST TOTAL PENDAPATAN
    // =====================================
    public function testTotalPendapatan()
    {
        $total = $this->db->table('transaksi')
            ->selectSum('total')
            ->get()
            ->getRow()
            ->total;

        $this->assertEquals(30000, $total);
    }
}