<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailTransaksi extends Migration
{
public function up()
{
    $this->forge->addField([
        'id_detail' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'id_transaksi' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'id_produk' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'qty' => [
            'type' => 'INT',
        ],
        'harga' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
        ],
        'subtotal' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
        ],
    ]);

    $this->forge->addKey('id_detail', true);

    $this->forge->addForeignKey(
        'id_transaksi',
        'transaksi',
        'id_transaksi',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->addForeignKey(
        'id_produk',
        'produk',
        'id_produk',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->createTable('detail_transaksi');
}

    public function down()
    {
        $this->forge->dropTable('detail_transaksi', true);
        // --- IGNORE ---
    }
}
