<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDescrizioneToLicenze extends Migration
{
    public function up()
    {

        $this->forge->dropColumn('licenze', 'descrizione');
    }

    public function down()
    {
        $fields = [
            'descrizione' => [
                'name' => 'descrizione',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ];
        $this->forge->addColumn('licenze', $fields);
    }
}
