<?php

namespace App\Models;

use CodeIgniter\Model;

class AggiornamentiModel extends Model
{
    protected $table            = 'aggiornamenti';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'licenze_id',
        'versioni_id',
        'note',
        'dt_agg',
        'stato',
    ];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getByLicenza($id_licenza)
    {
        log_message('info', 'AggiornamentiModel::getByLicenza - ID Licenza: ' . $id_licenza);
        $aggiornamenti = $this->select('aggiornamenti.*, versioni.codice AS versione')
            ->join('versioni', 'versioni.id = aggiornamenti.versioni_id', 'left')
            ->where('aggiornamenti.licenze_id', $id_licenza)
            ->orderBy('aggiornamenti.dt_agg', 'DESC')
            ->findAll();
        //log_message('info', 'AggiornamentiModel::getByLicenza - Query: ' . $this->getLastQuery());
        // Esegui la query e restituisci i risultati
        log_message('info', 'AggiornamentiModel::getByLicenza - Risultati: ' . print_r($aggiornamenti, true));

        return $aggiornamenti;
    }
    function getById($idAggiornamento)
    {
        log_message('info', 'AggiornamentiModel::getById - ID aggiornamento: ' . $idAggiornamento);
        $aggiornamento = $this->select('aggiornamenti.*, versioni.codice AS versione')
            ->join('versioni', 'versioni.id = aggiornamenti.versioni_id', 'left')
            ->where('aggiornamenti.id', $idAggiornamento)
            ->first();
        if (!$aggiornamento) {
            log_message('error', 'AggiornamentiModel::getById - Aggiornamento non trovato per ID: ' . $idAggiornamento);
            return null; // O gestire l'errore come preferisci
        }
        //log_message('info', 'AggiornamentiModel::getByLicenza - Query: ' . $this->getLastQuery());
        // Esegui la query e restituisci i risultati
        log_message('info', 'AggiornamentiModel::getById- Risultato: ' . print_r($aggiornamento, true));

        return $aggiornamento;
    }
}
