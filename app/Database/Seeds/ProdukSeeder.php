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
                'foto_produk' => '1772317818_a74156729ace1263fd13.jpg',
                'id_kategori' => 1,
                'id_supplier' => 1,
            ],
            [
                'nama_produk' => 'Kalung Kucing Lonceng',
                'harga' => 10000,
                'stok' => 50,
                'foto_produk' => '1772321897_f5b24620c7a9c51b0a45.jpg',
                'id_kategori' => 2,
                'id_supplier' => 2,
            ],
            [
                'nama_produk' => 'Vitamin Kucing dan Anjing Vibrac Nutri Plus Gel 120.5 gram',
                'harga' => 160000,
                'stok' => 10,
                'foto_produk' => '1772317780_9ef8a41573e3c295db72.png',
                'id_kategori' => 3,
                'id_supplier' => 3,
            ],
            [
                'nama_produk' => 'Royal Canin Persian Adult 4Kg Dry Makanan Kucing Dewasa',
                'harga' => 160000,
                'stok' => 10,
                'foto_produk' => '1772317754_0c79ed6b0fda5ed7981b.jpg',
                'id_kategori' => 1,
                'id_supplier' => 1,
            ],
        ];

        $this->db->table('produk')->insertBatch($data);
    }
}