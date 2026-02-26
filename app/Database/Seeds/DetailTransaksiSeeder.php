<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailTransaksiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_transaksi' => 1,
                'id_produk' => 1,
                'qty' => 1,
                'harga' => 50000,
                'subtotal' => 50000
            ],
            [
                'id_transaksi' => 2,
                'id_produk' => 2,
                'qty' => 1,
                'harga' => 75000,
                'subtotal' => 75000
            ],
        ];

        $this->db->table('detail_transaksi')->insertBatch($data);
    }
}