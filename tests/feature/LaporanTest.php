<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class LaporanTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;
    protected $userId;

    protected $existingDetailTransaksi = [];
    protected $existingTransaksi = [];
    protected $existingUsers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = \Config\Database::connect();

        // Backup data asli
        $this->existingDetailTransaksi = $this->db->table('detail_transaksi')->get()->getResultArray();
        $this->existingTransaksi       = $this->db->table('transaksi')->get()->getResultArray();
        $this->existingUsers           = $this->db->table('users')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        // Insert data dummy
        $this->db->table('users')->insert([
            'username' => 'admin_test',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);
        $this->userId = $this->db->insertID();

        $this->db->table('transaksi')->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 10000]);
        $this->db->table('transaksi')->insert(['id_user' => $this->userId, 'tanggal' => date('Y-m-d'), 'total' => 20000]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('detail_transaksi')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->table('users')->truncate();

        // Restore data asli
        if (!empty($this->existingUsers))           $this->db->table('users')->insertBatch($this->existingUsers);
        if (!empty($this->existingTransaksi))       $this->db->table('transaksi')->insertBatch($this->existingTransaksi);
        if (!empty($this->existingDetailTransaksi)) $this->db->table('detail_transaksi')->insertBatch($this->existingDetailTransaksi);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testLaporanRedirectJikaBelumLogin()
    {
        $result = $this->get('/laporan');
        $result->assertStatus(302);
    }

    public function testHalamanLaporan()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])->get('/laporan');
        $result->assertStatus(200);
    }

    public function testDataLaporanMuncul()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => $this->userId])->get('/laporan');
        $result->assertStatus(200);
        $result->assertSee('10.000');
        $result->assertSee('20.000');
    }

    public function testTotalTransaksi()
    {
        $count = $this->db->table('transaksi')->countAll();
        $this->assertEquals(2, $count);
    }

    public function testTotalPendapatan()
    {
        $total = $this->db->table('transaksi')->selectSum('total')->get()->getRow()->total;
        $this->assertEquals(30000, $total);
    }
}