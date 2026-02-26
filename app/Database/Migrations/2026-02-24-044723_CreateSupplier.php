<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSupplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_supplier' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id_supplier', true);
        $this->forge->createTable('supplier');
    }

    public function down()
    {
        $this->forge->dropTable('supplier', true);
    }
}
