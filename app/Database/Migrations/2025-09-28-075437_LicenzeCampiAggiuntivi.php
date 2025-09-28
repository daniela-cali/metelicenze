<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LicenzeCampiAggiuntivi extends Migration
{ 
    public function up()
    {
        $fields = [

            'server' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
                'comment'    => 'Server di collegamento al database della licenza',
            ],
            'conn' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
                'comment'    => 'Stringhe di connessione',
            ],
            'ambiente' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nome dell\'ambiente della licenza',
            ],
            'nodo' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nodo di collegamento all\'ambiente licenza',
            ],
            'invii' => [
                'type'       => 'INT',
                'null'       => true,
                'default'    => 0,
                'comment'    => 'Numero di invii acquistati',
            ],
            'giga' => [
                'type'       => 'SMALLINT',
                'null'       => true,
                'default'    => 0,
                'comment'    => 'Giga inclusi',
            ],


        ];
        $this->forge->addColumn('licenze', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('licenze', ['postazioni', 'server', 'conn', 'ambiente', 'nodo', 'invii', 'giga', 'note']);
    }
}
