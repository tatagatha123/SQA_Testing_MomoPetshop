<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksi extends Migration
{
public function up()
{
    $this->forge->addField([
        'id_transaksi' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'id_user' => [
            'type' => 'INT',
            'unsigned' => true,
        ],
        'tanggal' => [
            'type' => 'DATETIME',
        ],
        'total' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
            'default' => 0
        ],
    ]);

    $this->forge->addKey('id_transaksi', true);

    $this->forge->addForeignKey(
        'id_user',
        'users',
        'id_user',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->createTable('transaksi');
}

    public function down()
    {
        $this->forge->dropTable('transaksi', true);
    }
}
