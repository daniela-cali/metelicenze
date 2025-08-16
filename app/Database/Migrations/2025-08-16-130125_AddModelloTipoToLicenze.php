<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModelloTipoToLicenze extends Migration
{
    public function up()
    {
         $fields = [
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
                'null'       => false,   
                'default'    => null,
                'comment'    => 'Modello della licenza, ad esempio: SI Sigla, VA VarHub, SK SKTN',
            ],
            'modello' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false,   
                'default'    => null,
                'comment'    => 'Modello della licenza S Start, U Ultimate, C Cloud, null nessun modello specifico',
            ],
        ];
        $this->forge->addColumn('licenze', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('licenze', ['tipo', 'modello']);
    }
}
