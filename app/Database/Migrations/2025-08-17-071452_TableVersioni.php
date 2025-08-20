<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableVersioni extends Migration
{
    public function up()
    {
        $fields = [
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'auto_increment' => true,
                    ],
                    'codice' => [
                        'type' => 'VARCHAR',
                        'constraint' => 50,
                        'null' => false,
                    ],
                    'release' => [
                        'type' => 'VARCHAR',
                        'constraint' => 10,
                        'null' => false,
                    ],
                    'note_versione' => [
                        'type' => 'TEXT',
                        'null' => true,
                    ],
                    'dt_rilascio' => [
                        'type' => 'DATETIME',
                        'null' => false,
                    ],
                    'stato' => [
                        'type' => 'boolean',
                        'default' => true,
                        'null' => false,
                    ],

                    // Timestamps
                    'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
                    'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('versioni');
    }

    public function down()
    {
        $this->forge->dropTable('versioni', true);
    }
}
