<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AggiornamentiDate extends Migration
{
    public function up()
    {
        $fields = [
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data di creazione del record',
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data di ultima modifica del record',
            ],
        ];

        $this->forge->addColumn('licenze', $fields);
        $this->forge->addColumn('aggiornamenti', $fields);

    }

    public function down()
    {
        $fields = [
            'created_at',
            'updated_at',
        ];
        $this->forge->dropColumn('licenze', $fields);
        $this->forge->dropColumn('aggiornamenti', $fields);

    }
}
