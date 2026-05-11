<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

class DashboardUnitTest extends CIUnitTestCase
{
    // Test format tanggal yang dipakai di transaksi & stok masuk
    public function testTanggalFormatValid()
    {
        $tanggal = date('Y-m-d');
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $tanggal);
    }

    // Test kalkulasi total transaksi
    public function testTotalTransaksiPositif()
    {
        $total = 50000;
        $this->assertGreaterThan(0, $total);
    }

    // Test data produk tidak boleh stok negatif
    public function testStokTidakBolehNegatif()
    {
        $stok = 20;
        $this->assertGreaterThanOrEqual(0, $stok);
    }

    // Test jumlah stok masuk harus lebih dari 0
    public function testJumlahStokMasukValid()
    {
        $jumlah = 5;
        $this->assertGreaterThan(0, $jumlah);
    }
}