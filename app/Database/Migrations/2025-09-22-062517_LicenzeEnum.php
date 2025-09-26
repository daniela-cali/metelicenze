<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LicenzeEnum extends Migration
{
 public function up()
    {
        $fields = [
            'tipo' => [
                'type'       => "ENUM('Sigla','VarHub','SKNT')",
                'default'    => null,
            ],
            'modello' => [
                'type'       => "ENUM('Start','Ultimate','Cloud','N/A')",
                'default'    => null,
            ],
        ];

        $this->forge->modifyColumn('licenze', $fields);
    }

    public function down()
    {
        $fields = [
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
                'default'    => null,
            ],
                'modello' => [
                'type'       => "VARCHAR",
                'constraint' => 10,
                'default'    => null,
            ],
        ];

        $this->forge->modifyColumn('utenti', $fields);
    }
}
