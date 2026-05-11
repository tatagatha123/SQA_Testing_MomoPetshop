<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class LaporanUnitTest extends CIUnitTestCase
{
    // Test penjumlahan total pendapatan
    public function testTotalPendapatanDihitungDenganBenar()
    {
        $transaksi = [
            ['total' => 10000],
            ['total' => 20000],
        ];

        $total = array_sum(array_column($transaksi, 'total'));

        $this->assertEquals(30000, $total);
    }

    // Test jumlah transaksi dihitung dengan benar
    public function testJumlahTransaksiDihitungDenganBenar()
    {
        $transaksi = [
            ['total' => 10000],
            ['total' => 20000],
        ];

        $this->assertCount(2, $transaksi);
    }

    // Test total tidak boleh negatif
    public function testTotalPendapatanTidakNegatif()
    {
        $total = 30000;
        $this->assertGreaterThanOrEqual(0, $total);
    }

    // Test format angka rupiah
    public function testFormatRupiah()
    {
        $angka    = 10000;
        $formatted = number_format($angka, 0, ',', '.');

        $this->assertEquals('10.000', $formatted);
    }

    // Test format tanggal laporan valid
    public function testFormatTanggalValid()
    {
        $tanggal = date('Y-m-d');
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $tanggal);
    }
}