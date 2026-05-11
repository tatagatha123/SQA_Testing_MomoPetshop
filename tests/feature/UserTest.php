<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class UserTest extends CIUnitTestCase
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

        // user login dummy
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

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    // =====================================
    // TEST HALAMAN USER
    // =====================================
    public function testUserIndex()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin'
        ])->get('/user');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST HALAMAN CREATE
    // =====================================
    public function testUserCreatePage()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin'
        ])->get('/user/create');

        $result->assertStatus(200);
    }

    // =====================================
    // TEST TAMBAH USER BERHASIL
    // =====================================
    public function testStoreUserSuccess()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin',
        ])->post('/user/store', [
            'username' => 'userbaru',
            'password' => '123456',
            'konfirmasi_password' => '123456',
        ]);

        $result->assertRedirectTo('/user');
    }

    // =====================================
    // TEST VALIDASI GAGAL
    // =====================================
    public function testStoreUserValidationFailed()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin',
        ])->post('/user/store', [
            'username' => '',
            'password' => '123',
            'konfirmasi_password' => '321',
        ]);

        $result->assertStatus(200);
    }

    // =====================================
    // TEST DELETE USER
    // =====================================
    public function testDeleteUser()
    {
        // insert user baru
        $this->db->table('users')->insert([
            'username' => 'hapus_user',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        $userId = $this->db->insertID();

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin'
        ])->get('/user/delete/' . $userId);

        $result->assertRedirectTo('/user');
    }

    // =====================================
    // TEST TIDAK BISA HAPUS DIRI SENDIRI
    // =====================================
    public function testDeleteDiriSendiri()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => 1,
            'username'  => 'admin'
        ])->get('/user/delete/1');

        $result->assertRedirectTo('/user');
    }
}