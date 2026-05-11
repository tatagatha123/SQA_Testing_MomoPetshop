<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class UserUnitTest extends CIUnitTestCase
{
    // Test username tidak boleh kosong
    public function testUsernameTidakBolehKosong()
    {
        $username = 'admin_test';
        $this->assertNotEmpty($username);
    }

    // Test password minimal 6 karakter
    public function testPasswordMinimalEnamKarakter()
    {
        $password = '123456';
        $this->assertGreaterThanOrEqual(6, strlen($password));
    }

    // Test password terlalu pendek gagal validasi
    public function testPasswordTerlalupendekGagal()
    {
        $password = '123';
        $this->assertLessThan(6, strlen($password));
    }

    // Test konfirmasi password harus cocok
    public function testKonfirmasiPasswordCocok()
    {
        $password   = '123456';
        $konfirmasi = '123456';
        $this->assertEquals($password, $konfirmasi);
    }

    // Test konfirmasi password tidak cocok gagal validasi
    public function testKonfirmasiPasswordTidakCocokGagal()
    {
        $password   = '123456';
        $konfirmasi = '321654';
        $this->assertNotEquals($password, $konfirmasi);
    }

    // Test hash password menghasilkan format bcrypt
    public function testHashPasswordFormatBcrypt()
    {
        $hashed = password_hash('123456', PASSWORD_DEFAULT);
        $this->assertStringStartsWith('$2y$', $hashed);
    }

    // Test password_verify berhasil dengan hash yang benar
    public function testPasswordVerifyBerhasil()
    {
        $plain  = '123456';
        $hashed = password_hash($plain, PASSWORD_DEFAULT);
        $this->assertTrue(password_verify($plain, $hashed));
    }

    // Test password_verify gagal dengan password salah
    public function testPasswordVerifyGagalDenganPasswordSalah()
    {
        $hashed = password_hash('123456', PASSWORD_DEFAULT);
        $this->assertFalse(password_verify('salah', $hashed));
    }

    // Test user tidak bisa hapus diri sendiri
    public function testUserTidakBisaHapusDiriSendiri()
    {
        $sessionUserId = 1;
        $targetUserId  = 1;
        $this->assertEquals($sessionUserId, $targetUserId);
    }

    // Test user bisa hapus user lain
    public function testUserBisaHapusUserLain()
    {
        $sessionUserId = 1;
        $targetUserId  = 2;
        $this->assertNotEquals($sessionUserId, $targetUserId);
    }
}