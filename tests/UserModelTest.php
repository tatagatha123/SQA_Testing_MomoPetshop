<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;

class UserModelTest extends CIUnitTestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new UserModel();
    }

    // Test hash password
    public function testHashPassword()
    {
        $plain = "123456";
        $hashed = $this->model->hashPassword($plain);

        $this->assertNotEquals($plain, $hashed);
        $this->assertTrue(password_verify($plain, $hashed));
    }

    // Test insert + find user
    public function testFindByUsername()
    {
        $username = "testuser";
        $password = $this->model->hashPassword("123");

        $this->model->insert([
            'username' => $username,
            'password' => $password
        ]);

        $user = $this->model->findByUsername($username);

        $this->assertNotNull($user);
        $this->assertEquals($username, $user['username']);
    }

    // Test login berhasil
    public function testVerifyLoginSuccess()
    {
        $mock = $this->getMockBuilder(UserModel::class)
                    ->onlyMethods(['findByUsername'])
                    ->getMock();

        $plainPassword = "123";
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $mock->method('findByUsername')
            ->willReturn([
                'username' => 'testuser',
                'password' => $hashedPassword
            ]);

        $result = $mock->verifyLogin('testuser', $plainPassword);

        $this->assertNotNull($result);
    }

    // Test login gagal (password salah)
    public function testVerifyLoginWrongPassword()
    {
        $mock = $this->getMockBuilder(UserModel::class)
                    ->onlyMethods(['findByUsername'])
                    ->getMock();

        $mock->method('findByUsername')
            ->willReturn([
                'username' => 'testuser',
                'password' => password_hash('123', PASSWORD_BCRYPT)
            ]);

        $result = $mock->verifyLogin('testuser', 'salah');

        $this->assertNull($result);
    }

    // Test login gagal (user tidak ada)
    public function testVerifyLoginUserNotFound()
    {
        $mock = $this->getMockBuilder(UserModel::class)
                    ->onlyMethods(['findByUsername'])
                    ->getMock();

        $mock->method('findByUsername')
            ->willReturn(null);

        $result = $mock->verifyLogin('tidakada', '123');

        $this->assertNull($result);
    }
}