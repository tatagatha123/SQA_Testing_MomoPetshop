<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class AuthIntegrationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        $user = $this->db->table('users')
            ->where('username', 'testadmin')
            ->get()
            ->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'testadmin',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
            ]);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('users')
            ->where('username', 'testadmin')
            ->delete();
    }

    // Halaman login bisa diakses
    public function testLoginPageLoads()
    {
        $result = $this->get('/login');
        $result->assertStatus(200);
    }

    // Login berhasil → redirect ke dashboard
    public function testLoginSuccess()
    {
        $result = $this->post('/login', [
            'username' => 'testadmin',
            'password' => '123456',
        ]);
        $result->assertRedirectTo('/dashboard');
    }

    // Login gagal → tetap di halaman login (200)
    public function testLoginFailed()
    {
        $result = $this->post('/login', [
            'username' => 'testadmin',
            'password' => 'salah',
        ]);
        $result->assertStatus(200);
    }

    // Register berhasil → redirect ke login
    public function testRegisterSuccess()
    {
        // Pastikan user tidak ada dulu
        $this->db->table('users')->where('username', 'userbaru')->delete();

        $result = $this->post('/register', [
            'username'            => 'userbaru',
            'password'            => '123456',
            'konfirmasi_password' => '123456',
        ]);
        $result->assertRedirectTo('/login');

        // Cleanup
        $this->db->table('users')->where('username', 'userbaru')->delete();
    }

    // Logout berhasil → redirect ke login
    public function testLogout()
    {
        session()->set(['logged_in' => true]);

        $result = $this->get('/logout');
        $result->assertRedirectTo('/login');
    }
}