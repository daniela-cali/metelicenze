<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiModel extends Model
{
    protected $table            = 'nrg.v_tbcf_tbana';
    protected $primaryKey       = 'tbana_id_pk';
    
    protected $returnType       = 'object';

public function getClienti()
{
    return $this->select([
            'tbcf_cd as codice_cliente',
            'tbana_id_pk as id',
            'tbana_ragsoc1 as nome',
            'tbana_indirizzo1 as indirizzo',
            'tbana_citta as citta',
            'tbana_cap as cap',
            'tbana_provincia as provincia',
            'tbana_telefono1 as telefono',  
            'tbana_email as email'
        ])
        ->orderBy('tbana_ragsoc1', 'ASC')
        ->where('tbcf_tp', 'C')
        ->findAll();
}

public function getClientiById($id)
{
    return $this->select([
            'tbcf_cd as codice_cliente',
            'tbana_id_pk as id',
            'tbana_ragsoc1 as nome',
            'tbana_indirizzo1 as indirizzo',
            'tbana_citta as citta',
            'tbana_cap as cap',
            'tbana_provincia as provincia',
            'tbana_telefono1 as telefono',  
            'tbana_email as email'
        ])
        ->orderBy('tbana_ragsoc1', 'ASC')
        ->where('tbcf_tp', 'C')
        ->where('tbana_id_pk', $id)
        ->first();
}

}
