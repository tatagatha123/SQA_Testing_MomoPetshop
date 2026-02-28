<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoProdukToProduk extends Migration
{
    public function up()
    {
        $this->forge->addColumn('produk', [
            'foto_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'stok',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produk', 'foto_produk');
    }
}
