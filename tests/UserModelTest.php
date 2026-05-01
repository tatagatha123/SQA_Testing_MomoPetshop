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
        $username = "loginuser";
        $plainPassword = "123";

        $this->model->insert([
            'username' => $username,
            'password' => $this->model->hashPassword($plainPassword)
        ]);

        $result = $this->model->verifyLogin($username, $plainPassword);

        $this->assertNotNull($result);
        $this->assertEquals($username, $result['username']);
    }

    // Test login gagal (password salah)
    public function testVerifyLoginWrongPassword()
    {
        $username = "wrongpass";
        
        $this->model->insert([
            'username' => $username,
            'password' => $this->model->hashPassword("123")
        ]);

        $result = $this->model->verifyLogin($username, "salah");

        $this->assertNull($result);
    }

    // Test login gagal (user tidak ada)
    public function testVerifyLoginUserNotFound()
    {
        $result = $this->model->verifyLogin("tidakada", "123");

        $this->assertNull($result);
    }
}