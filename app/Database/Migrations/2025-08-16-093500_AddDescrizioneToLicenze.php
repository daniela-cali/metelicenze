<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescrizioneToLicenze extends Migration
{
    public function up()
    {
         $fields = [
            'descrizione' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,   
                'default'    => null,
            ],
        ];
        $this->forge->addColumn('licenze', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('licenze', 'descrizione');
    }
}
