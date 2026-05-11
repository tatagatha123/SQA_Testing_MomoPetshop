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

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testLoginPage()
    {
        $result = $this->get('/login');

        $result->assertStatus(200);
    }

    public function testRegisterSuccess()
    {
        $result = $this->withBodyFormat('json')->post('/register', [
            'username' => 'testuser',
            'password' => '123456',
            'konfirmasi_password' => '123456',
        ]);

        $result->assertRedirectTo('/login');
    }

    public function testLoginSuccess()
    {
        $this->db->table('users')->insert([
            'username' => 'admin',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $result = $this->withBodyFormat('json')->post('/login', [
            'username' => 'admin',
            'password' => '123456',
        ]);

        $result->assertRedirectTo('/dashboard');
    }

    public function testLoginFailed()
    {
        $this->db->table('users')->insert([
            'username' => 'admin',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $result = $this->post('/login', [
            'username' => 'admin',
            'password' => 'salah',
        ]);

        $result->assertStatus(200);
    }

    public function testLogout()
    {
        session()->set([
            'logged_in' => true,
        ]);

        $result = $this->get('/logout');

        $result->assertRedirectTo('/login');
    }
}