<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_produk' => 'Whiskas 1kg',
                'harga' => 50000,
                'stok' => 20,
                'id_kategori' => 1,
                'id_supplier' => 1,
            ],
            [
                'nama_produk' => 'Kalung Kucing',
                'harga' => 25000,
                'stok' => 15,
                'id_kategori' => 2,
                'id_supplier' => 2,
            ],
            [
                'nama_produk' => 'Vitamin Kucing',
                'harga' => 30000,
                'stok' => 10,
                'id_kategori' => 3,
                'id_supplier' => 3,
            ],
        ];

        $this->db->table('produk')->insertBatch($data);
    }
}