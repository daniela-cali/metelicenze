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

    function getLastAggiornamenti()
    {
        $db = \Config\Database::connect();
        $subquery = $db->table('aggiornamenti a2')
            ->select('MAX(a2.dt_agg)')
            ->where('a2.licenze_id = aggiornamenti.licenze_id')
            ->getCompiledSelect();

        $builder = $db->table('aggiornamenti')
            ->select('aggiornamenti.id as aggiornamento_id, aggiornamenti.dt_agg as ultimo_aggiornamento, versioni.id AS versione_id, versioni.codice AS versione_codice, licenze.codice AS licenza_codice, licenze.id AS licenza_id, licenze.id_cli_ext AS cliente_id ')
            ->join('versioni', 'aggiornamenti.versioni_id = versioni.id')
            ->join('licenze', 'aggiornamenti.licenze_id = licenze.id')
            ->where("aggiornamenti.dt_agg = ($subquery)", null, false);

        $query = $builder->get();
        $ultimiAggiornamenti = $query->getResult();
        //log_message('info', 'AggiornamentiModel::getLastAggiornamenti - Risultati: ' . print_r($ultimiAggiornamenti, true));
        return $ultimiAggiornamenti;
    }
}
