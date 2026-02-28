<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_produk' => 'Cat Choize Tuna Adult Makanan Kucing 800gram',
                'harga' => 23000,
                'stok' => 20,
                'foto_produk' => public/uploads/produk/1772317818_a74156729ace1263fd13.jpg,
                'id_kategori' => 1,
                'id_supplier' => 1,
            ],
            [
                'nama_produk' => 'Kalung Kucing Lonceng',
                'harga' => 10000,
                'stok' => 50,
                'foto_produk' => null,
                'id_kategori' => 2,
                'id_supplier' => 2,
            ],
            [
                'nama_produk' => 'Vitamin Kucing dan Anjing Vibrac Nutri Plus Gel 120.5 gram',
                'harga' => 160000,
                'stok' => 10,
                'foto_produk' => null,
                'id_kategori' => 3,
                'id_supplier' => 3,
            ],
            [
                'nama_produk' => 'Royal Canin Persian Adult 4Kg Dry Makanan Kucing Dewasa',
                'harga' => 160000,
                'stok' => 10,
                'foto_produk' => null,
                'id_kategori' => 3,
                'id_supplier' => 1,
            ],
        ];

        $this->db->table('produk')->insertBatch($data);
    }
}