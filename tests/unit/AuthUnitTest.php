<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class AuthUnitTest extends CIUnitTestCase
{
    // Test hash & verify password
    public function testPasswordHashAndVerify()
    {
        $plain  = '123456';
        $hashed = password_hash($plain, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($plain, $hashed));
    }

    public function testWrongPasswordFails()
    {
        $hashed = password_hash('123456', PASSWORD_DEFAULT);

        $this->assertFalse(password_verify('salah', $hashed));
    }

    public function testHashIsDifferentEachTime()
    {
        $hash1 = password_hash('123456', PASSWORD_DEFAULT);
        $hash2 = password_hash('123456', PASSWORD_DEFAULT);

        $this->assertNotEquals($hash1, $hash2);
    }
}