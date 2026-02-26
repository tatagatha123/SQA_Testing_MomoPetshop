<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_supplier' => 'PT Health Pet',
                'no_telp' => '081234567890',
            ],
            [
                'nama_supplier' => 'CV Animal Care',
                'no_telp' => '082345678901',
            ],
            [
                'nama_supplier' => 'CV Pet Supplies',
                'no_telp' => '083456789012',
            ],
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}