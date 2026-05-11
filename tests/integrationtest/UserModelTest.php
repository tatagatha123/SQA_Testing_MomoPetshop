<?php

namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;
use Config\Database;

class UserModelTest extends CIUnitTestCase
{
    protected UserModel $model;
    protected $db;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new UserModel();
        $this->db    = Database::connect();

        $user = $this->db->table('users')
            ->where('username', 'admin_test')
            ->get()->getRowArray();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'admin_test',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
            ]);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('users')
            ->where('username', 'admin_test')
            ->delete();
    }

    // hashPassword() menghasilkan hash yang berbeda dari plain
    public function testHashPassword()
    {
        $plain  = '123456';
        $hashed = $this->model->hashPassword($plain);

        $this->assertNotEquals($plain, $hashed);
        $this->assertTrue(password_verify($plain, $hashed));
    }

    // findByUsername() mengembalikan data user yang benar
    public function testFindByUsername()
    {
        $user = $this->model->findByUsername('admin_test');

        $this->assertNotNull($user);
        $this->assertIsArray($user);
        $this->assertEquals('admin_test', $user['username']);
    }

    // Password di DB ter-hash dengan benar
    public function testAdminPasswordHash()
    {
        $user = $this->model->findByUsername('admin_test');

        $this->assertNotNull($user);
        $this->assertTrue(password_verify('123456', $user['password']));
    }

    // verifyLogin() berhasil dengan kredensial yang benar
    public function testLoginAdmin()
    {
        $result = $this->model->verifyLogin('admin_test', '123456');

        $this->assertNotNull($result);
        $this->assertEquals('admin_test', $result['username']);
    }

    // verifyLogin() gagal dengan password salah
    public function testVerifyLoginWrongPassword()
    {
        $result = $this->model->verifyLogin('admin_test', 'password_salah');

        $this->assertNull($result);
    }

    // verifyLogin() gagal jika user tidak ada
    public function testVerifyLoginUserNotFound()
    {
        $result = $this->model->verifyLogin('user_tidak_ada', '123456');

        $this->assertNull($result);
    }
}