<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableClienti extends Migration
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
                        'constraint' => 15,
                        'null' => false,
                    ],
                    'nome' => [
                        'type' => 'VARCHAR',
                        'constraint' => 50,
                        'null' => false,
                    ],
                    'piva' => [
                        'type' => 'VARCHAR',
                        'constraint' => 15,
                        'null' => true,
                    ],
                    'indirizzo' => [
                        'type' => 'VARCHAR',
                        'constraint' => 50,
                        'null' => false,
                    ],
                    'citta' => [
                        'type' => 'VARCHAR',
                        'constraint' => 30,
                        'null' => false,
                    ],
                    'cap' => [
                        'type' => 'VARCHAR',
                        'constraint' => 10,
                        'null' => false,
                    ],
                    'provincia' => [
                        'type' => 'VARCHAR',
                        'constraint' => 5,
                        'null' => false,
                    ],
                    'telefono' => [
                        'type' => 'VARCHAR',
                        'constraint' => 20,
                        'null' => true,
                    ],
                    'email' => [
                        'type' => 'VARCHAR',
                        'constraint' => 50,
                        'null' => true,
                    ],
                    'note' => [
                        'type' => 'TEXT',
                        'null' => true,
                    ],
                    'contatti' => [
                        'type' => 'TEXT',
                        'null' => true,
                    ],
                    'id_external' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'null' => true,
                    ],
                    'dt_import' => [
                        'type' => 'DATE',
                        'null' => true,
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
        $this->forge->createTable('clienti');
    }

    public function down()
    {
        $this->forge->dropTable('clienti', true);
    }
}
