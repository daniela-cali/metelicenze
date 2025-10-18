<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UtenteImportSuClienti extends Migration
{
    public function up()
    {
        $fields = [
            'utente_import' => [
                'type'       => 'integer',
                'null'       => true,   
                'default'    => null,
            ],
        ];
        $this->forge->addColumn('clienti', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('clienti', 'utente_import');
    }
}
