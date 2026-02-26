<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_stok' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_produk' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_supplier' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'jumlah' => [
                'type' => 'INT',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('id_stok', true);
        $this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id_supplier', 'CASCADE', 'CASCADE');

        $this->forge->createTable('stok_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('stok_masuk', true);
        // --- IGNORE ---
    }
}
