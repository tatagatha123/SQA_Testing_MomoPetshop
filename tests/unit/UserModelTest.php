<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;
use Config\Database;

class UserModelTest extends CIUnitTestCase
{
    protected $model;
    protected $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new UserModel();
        $this->db = Database::connect();

        // cek user test
        $user = $this->db->table('users')
            ->where('username', 'admin_test')
            ->get()
            ->getRowArray();

        // insert kalau belum ada
        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'admin_test',
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

        // hapus user testing
        $this->db->table('users')
            ->where('username', 'admin_test')
            ->delete();
    }

    // =====================================
    // TEST HASH PASSWORD
    // =====================================
    public function testHashPassword()
    {
        $plainPassword = '123456';

        $hashedPassword = $this->model
            ->hashPassword($plainPassword);

        $this->assertNotEquals(
            $plainPassword,
            $hashedPassword
        );

        $this->assertTrue(
            password_verify(
                $plainPassword,
                $hashedPassword
            )
        );
    }

    // =====================================
    // TEST USER ADA
    // =====================================
    public function testFindByUsername()
    {
        $user = $this->model
            ->findByUsername('admin_test');

        $this->assertNotNull($user);

        $this->assertIsArray($user);

        $this->assertEquals(
            'admin_test',
            $user['username']
        );
    }

    // =====================================
    // TEST HASH PASSWORD VALID
    // =====================================
    public function testAdminPasswordHash()
    {
        $user = $this->model
            ->findByUsername('admin_test');

        $this->assertNotNull($user);

        $this->assertTrue(
            password_verify(
                '123456',
                $user['password']
            )
        );
    }

    // =====================================
    // TEST LOGIN BERHASIL
    // =====================================
    public function testLoginAdmin()
    {
        $result = $this->model->verifyLogin(
            'admin_test',
            '123456'
        );

        $this->assertNotNull($result);

        $this->assertEquals(
            'admin_test',
            $result['username']
        );
    }

    // =====================================
    // TEST LOGIN GAGAL
    // =====================================
    public function testVerifyLoginWrongPassword()
    {
        $result = $this->model->verifyLogin(
            'admin_test',
            'password_salah'
        );

        $this->assertNull($result);
    }

    // =====================================
    // TEST USER TIDAK ADA
    // =====================================
    public function testVerifyLoginUserNotFound()
    {
        $result = $this->model->verifyLogin(
            'user_tidak_ada',
            '123456'
        );

        $this->assertNull($result);
    }
}