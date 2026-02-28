<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'tanggal' => date('Y-m-d H:i:s'),
                'total' => 23000
            ],
            [
                'id_user' => 2,
                'tanggal' => date('Y-m-d H:i:s'),
                'total' => 10000
            ],
        ];

        $this->db->table('transaksi')->insertBatch($data);
    }
}