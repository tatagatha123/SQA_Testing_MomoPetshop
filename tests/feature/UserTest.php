<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class UserTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;
    protected $existingUsers = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        // Backup data asli
        $this->existingUsers = $this->db->table('users')->get()->getResultArray();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Insert data dummy
        $this->db->table('users')->insert([
            'username' => 'admin',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('users')->truncate();

        // Restore data asli
        if (!empty($this->existingUsers)) {
            $this->db->table('users')->insertBatch($this->existingUsers);
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function testUserIndex()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])->get('/user');
        $result->assertStatus(200);
    }

    public function testUserCreatePage()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])->get('/user/create');
        $result->assertStatus(200);
    }

    public function testStoreUserSuccess()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])
            ->post('/user/store', [
                'username'            => 'userbaru',
                'password'            => '123456',
                'konfirmasi_password' => '123456',
            ]);
        $result->assertRedirectTo('/user');
    }

    public function testStoreUserValidationFailed()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])
            ->post('/user/store', [
                'username'            => '',
                'password'            => '123',
                'konfirmasi_password' => '321',
            ]);
        $result->assertStatus(200);
    }

    public function testDeleteUser()
    {
        $this->db->table('users')->insert([
            'username' => 'hapus_user',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);
        $userId = $this->db->insertID();

        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])
            ->get('/user/delete/' . $userId);
        $result->assertRedirectTo('/user');
    }

    public function testDeleteDiriSendiri()
    {
        $result = $this->withSession(['logged_in' => true, 'id_user' => 1, 'username' => 'admin'])
            ->get('/user/delete/1');
        $result->assertRedirectTo('/user');
    }
}