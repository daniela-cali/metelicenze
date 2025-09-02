<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiModel extends Model
{
    protected $DBGroup          = 'external';
    protected $transcoding = true; // Abilita la transcodifica dei campi
    protected $transcodingArray = [
        'tbcf_cd' => 'codice_cliente',
        'tbana_id_pk' => 'id',
        'tbana_ragsoc1' => 'nome',
        'tbana_indirizzo1' => 'indirizzo',
        'tbana_citta' => 'citta',
        'tbana_cap' => 'cap',
        'tbana_provincia' => 'provincia',
        'tbana_telefono1' => 'telefono',
        'tbana_email' => 'email'
    ];
    protected $transcodedFields = '';

    protected $table            = 'nrg.v_tbcf_tbana';
    protected $primaryKey       = 'tbana_id_pk';

    protected $returnType       = 'object';


    protected function initialize()
    {
         if ($this->transcoding) {
            $fields = [];
            foreach ($this->transcodingArray as $dbField => $alias) {
                $fields[] = "$dbField as $alias";
            }
            $this->transcodedFields = implode(', ', $fields);
        }

    }


    /**
     * Genera l'elenco dei clienti
     */

    public function getClienti()
    {
        return $this->select($this->transcodedFields)
            ->orderBy('tbana_ragsoc1', 'ASC')
            ->where('tbcf_tp', 'C')
            ->findAll();
    }

    public function getClientiById($id)
    {

        return $this->select($this->transcodedFields)
            ->orderBy('tbana_ragsoc1', 'ASC')
            ->where('tbcf_tp', 'C')
            ->where('tbana_id_pk', $id)
            ->first();
    }
}
