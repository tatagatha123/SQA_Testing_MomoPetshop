<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_supplier' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id_produk', true);

        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id_supplier', 'CASCADE', 'CASCADE');

        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk', true);
    }
}
