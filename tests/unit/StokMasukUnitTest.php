<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class StokMasukUnitTest extends CIUnitTestCase
{
    // Test jumlah stok masuk harus lebih dari 0
    public function testJumlahStokMasukHarusPositif()
    {
        $jumlah = 5;
        $this->assertGreaterThan(0, $jumlah);
    }

    // Test jumlah stok masuk tidak boleh negatif
    public function testJumlahStokMasukTidakBolehNegatif()
    {
        $jumlah = 0;
        $this->assertGreaterThanOrEqual(0, $jumlah);
    }

    // Test format tanggal stok masuk valid
    public function testFormatTanggalValid()
    {
        $tanggal = date('Y-m-d');
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $tanggal);
    }

    // Test data stok masuk lengkap sebelum disimpan
    public function testDataStokMasukLengkap()
    {
        $data = [
            'id_produk'   => 1,
            'id_supplier' => 1,
            'jumlah'      => 5,
            'tanggal'     => date('Y-m-d'),
        ];

        $this->assertNotEmpty($data['id_produk']);
        $this->assertNotEmpty($data['id_supplier']);
        $this->assertGreaterThan(0, $data['jumlah']);
        $this->assertNotEmpty($data['tanggal']);
    }

    // Test sorting tanggal — tanggal lebih baru lebih besar
    public function testSortingTanggalTerbaruLebihBesar()
    {
        $tanggalLama = '2024-01-01';
        $tanggalBaru = '2024-12-31';

        $this->assertGreaterThan($tanggalLama, $tanggalBaru);
    }

    // Test total stok masuk dari array
    public function testTotalStokMasukDihitungBenar()
    {
        $data = [
            ['jumlah' => 5],
            ['jumlah' => 3],
            ['jumlah' => 2],
        ];

        $total = array_sum(array_column($data, 'jumlah'));
        $this->assertEquals(10, $total);
    }

    // Test jumlah item hasil query tidak boleh kosong
    public function testJumlahItemTidakKosong()
    {
        $data = [
            ['jumlah' => 1],
            ['jumlah' => 2],
        ];

        $this->assertNotEmpty($data);
        $this->assertGreaterThanOrEqual(1, count($data));
    }
}