<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Makanan Kucing'],
            ['nama_kategori' => 'Aksesoris'],
            ['nama_kategori' => 'Vitamin'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}