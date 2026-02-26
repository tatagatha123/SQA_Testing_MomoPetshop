<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StokMasukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_produk' => 1,
                'id_supplier' => 1,
                'jumlah' => 20,
                'tanggal' => date('Y-m-d'),
            ],
            [
                'id_produk' => 2,
                'id_supplier' => 2,
                'jumlah' => 15,
                'tanggal' => date('Y-m-d'),
            ],
                        [
                'id_produk' => 3,
                'id_supplier' => 3,
                'jumlah' => 10,
                'tanggal' => date('Y-m-d'),
            ],
        ];

        $this->db->table('stok_masuk')->insertBatch($data);
    }
}