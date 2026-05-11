<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class AuthTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        // cek apakah user test sudah ada
        $user = $this->db->table('users')
            ->where('username', 'testadmin')
            ->get()
            ->getRowArray();

        // insert hanya jika belum ada
        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'testadmin',
                'password' => password_hash(
                    '123456',
                    PASSWORD_DEFAULT
                ),
            ]);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus hanya user testing
        $this->db->table('users')
            ->where('username', 'testadmin')
            ->delete();
    }

    // =====================================
    // TEST HALAMAN LOGIN
    // =====================================
    public function testLoginPage()
    {
        $result = $this->get('/login');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST REGISTER
    // =====================================
    public function testRegisterSuccess()
    {
        $result = $this->withBodyFormat('json')->post('/register', [
            'username' => 'userbaru',
            'password' => '123456',
            'konfirmasi_password' => '123456',
        ]);

        $result->assertRedirectTo('/login');
    }

    // =====================================
    // TEST LOGIN BERHASIL
    // =====================================
    public function testLoginSuccess()
    {
        $result = $this->withBodyFormat('json')->post('/login', [
            'username' => 'testadmin',
            'password' => '123456',
        ]);

        $result->assertRedirectTo('/dashboard');
    }

    // =====================================
    // TEST LOGIN GAGAL
    // =====================================
    public function testLoginFailed()
    {
        $result = $this->post('/login', [
            'username' => 'testadmin',
            'password' => 'salah',
        ]);

        $result->assertStatus(200);
    }

    // =====================================
    // TEST LOGOUT
    // =====================================
    public function testLogout()
    {
        session()->set([
            'logged_in' => true,
        ]);

        $result = $this->get('/logout');

        $result->assertRedirectTo('/login');
    }
}