<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VersioniCampoUltima extends Migration
{
    public function up()
    {
        $fields = [
            'ultima' => [
                'type'       => 'boolean',
                'null'       => false,   
                'default'    => false,
            ],
        ];
        $this->forge->addColumn('versioni', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('versioni', 'ultima');
    }
}
