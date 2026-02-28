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
                'harga' => 23000,
                'subtotal' => 23000
            ],
            [
                'id_transaksi' => 2,
                'id_produk' => 2,
                'qty' => 1,
                'harga' => 10000,
                'subtotal' => 10000
            ],
        ];

        $this->db->table('detail_transaksi')->insertBatch($data);
    }
}