<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        // Master Data
        $this->call('UsersSeeder');
        $this->call('SupplierSeeder');
        $this->call('KategoriSeeder');
        $this->call('ProdukSeeder');
        $this->call('StokMasukSeeder');

        // Transaksi
        $this->call('TransaksiSeeder');
        $this->call('DetailTransaksiSeeder');
    }
}