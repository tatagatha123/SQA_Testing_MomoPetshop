<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

class UserTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $db;
    protected $adminId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Database::connect();

        // =========================
        // CEK / INSERT ADMIN TEST
        // =========================
        $admin = $this->db->table('users')
            ->where('username', 'admin_test')
            ->get()
            ->getRowArray();

        if (!$admin) {
            $this->db->table('users')->insert([
                'username' => 'admin_test',
                'password' => password_hash(
                    '123456',
                    PASSWORD_DEFAULT
                ),
            ]);

            $this->adminId = $this->db->insertID();
        } else {
            $this->adminId = $admin['id_user'];
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // hapus user testing
        $this->db->table('users')
            ->whereIn('username', [
                'admin_test',
                'userbaru',
                'hapus_user'
            ])
            ->delete();
    }

    // =====================================
    // TEST HALAMAN USER
    // =====================================
    public function testUserIndex()
    {
        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->adminId,
            'username'  => 'admin_test'
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
            'id_user'   => $this->adminId,
            'username'  => 'admin_test'
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
            'id_user'   => $this->adminId,
            'username'  => 'admin_test',
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
            'id_user'   => $this->adminId,
            'username'  => 'admin_test',
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
        $this->db->table('users')->insert([
            'username' => 'hapus_user',
            'password' => password_hash(
                '123456',
                PASSWORD_DEFAULT
            ),
        ]);

        $userId = $this->db->insertID();

        $result = $this->withSession([
            'logged_in' => true,
            'id_user'   => $this->adminId,
            'username'  => 'admin_test'
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
            'id_user'   => $this->adminId,
            'username'  => 'admin_test'
        ])->get('/user/delete/' . $this->adminId);

        $result->assertRedirectTo('/user');
    }
}