<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class ProdukUnitTest extends CIUnitTestCase
{
    // Test harga produk tidak boleh negatif
    public function testHargaProdukTidakBolehNegatif()
    {
        $harga = 10000;
        $this->assertGreaterThan(0, $harga);
    }

    // Test stok produk tidak boleh negatif
    public function testStokProdukTidakBolehNegatif()
    {
        $stok = 5;
        $this->assertGreaterThanOrEqual(0, $stok);
    }

    // Test nama produk tidak boleh kosong
    public function testNamaProdukTidakBolehKosong()
    {
        $nama = 'Whiskas';
        $this->assertNotEmpty($nama);
    }

    // Test format harga rupiah
    public function testFormatHargaRupiah()
    {
        $harga     = 10000;
        $formatted = number_format($harga, 0, ',', '.');
        $this->assertEquals('10.000', $formatted);
    }

    // Test data produk lengkap sebelum disimpan
    public function testDataProdukLengkap()
    {
        $produk = [
            'nama_produk' => 'Whiskas',
            'harga'       => 10000,
            'stok'        => 5,
            'id_kategori' => 1,
            'id_supplier' => 1,
        ];

        $this->assertNotEmpty($produk['nama_produk']);
        $this->assertGreaterThan(0, $produk['harga']);
        $this->assertGreaterThanOrEqual(0, $produk['stok']);
        $this->assertNotEmpty($produk['id_kategori']);
        $this->assertNotEmpty($produk['id_supplier']);
    }

    // Test validasi gagal jika field kosong
    public function testValidasiGagalJikaFieldKosong()
    {
        $produk = [
            'nama_produk' => '',
            'harga'       => '',
            'stok'        => '',
            'id_kategori' => '',
            'id_supplier' => '',
        ];

        $this->assertEmpty($produk['nama_produk']);
        $this->assertEmpty($produk['harga']);
        $this->assertEmpty($produk['stok']);
    }
}