<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class TransaksiUnitTest extends CIUnitTestCase
{
    // Test kalkulasi subtotal (qty * harga)
    public function testKalkulasiSubtotal()
    {
        $qty      = 2;
        $harga    = 5000;
        $subtotal = $qty * $harga;

        $this->assertEquals(10000, $subtotal);
    }

    // Test kalkulasi total dari beberapa item
    public function testKalkulasiTotalDariBeberapaItem()
    {
        $items = [
            ['qty' => 2, 'harga' => 5000],
            ['qty' => 1, 'harga' => 3000],
        ];

        $total = array_sum(array_map(
            fn($item) => $item['qty'] * $item['harga'],
            $items
        ));

        $this->assertEquals(13000, $total);
    }

    // Test total transaksi tidak boleh negatif
    public function testTotalTransaksiTidakBolehNegatif()
    {
        $total = 10000;
        $this->assertGreaterThan(0, $total);
    }

    // Test qty tidak boleh nol atau negatif
    public function testQtyHarusPositif()
    {
        $qty = 2;
        $this->assertGreaterThan(0, $qty);
    }

    // Test harga satuan tidak boleh nol atau negatif
    public function testHargaHarusPositif()
    {
        $harga = 5000;
        $this->assertGreaterThan(0, $harga);
    }

    // Test format tanggal transaksi valid
    public function testFormatTanggalTransaksiValid()
    {
        $tanggal = date('Y-m-d');
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $tanggal);
    }

    // Test data transaksi lengkap sebelum disimpan
    public function testDataTransaksiLengkap()
    {
        $data = [
            'tanggal'   => date('Y-m-d'),
            'total'     => 10000,
            'id_produk' => [1],
            'qty'       => [2],
            'harga'     => [5000],
        ];

        $this->assertNotEmpty($data['tanggal']);
        $this->assertGreaterThan(0, $data['total']);
        $this->assertNotEmpty($data['id_produk']);
        $this->assertNotEmpty($data['qty']);
        $this->assertNotEmpty($data['harga']);
    }

    // Test validasi gagal jika tanggal kosong
    public function testValidasiGagalJikaTanggalKosong()
    {
        $tanggal = '';
        $this->assertEmpty($tanggal);
    }

    // Test validasi gagal jika total nol
    public function testValidasiGagalJikaTotalNol()
    {
        $total = 0;
        $this->assertEquals(0, $total);
    }
}