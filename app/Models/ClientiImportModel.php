<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiImportModel extends Model
{
    protected $DBGroup          = 'external';
    protected $transcoding = true; // Abilita la transcodifica dei campi
    protected $transcodingArray = [
        'tbana_id_pk' => 'id_external',
        'tbcf_cd' => 'codice_cliente',
        'tbana_ragsoc1' => 'nome',
        'tbana_piva' => 'piva',
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

    /**
     * Inizializza il modello e prepara i campi transcodificati
     */
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

    public function getForImport()
    {
        return $this->select($this->transcodedFields)
            ->orderBy('tbana_ragsoc1', 'ASC')
            ->where('tbcf_tp', 'C')
            ->findAll();
    }

    public function getRecordsetForImport()
    {
        $db = db_connect();
        $clientiIDs = $db->table('clienti')->select(['id', 'id_external'])->get()->getResult();
        //log_message('info', 'ClientiImportModel::getRecordsetForImport - clientiIDs: ' . print_r($clientiIDs, true));

        $mapClienti = [];

        foreach ($clientiIDs as $value) {
            $mapClienti[$value->id_external] = $value->id;
        }
        log_message('info', 'ClientiImportModel::getRecordsetForImport - mapClienti: ' . print_r($mapClienti, true));
        $clientiOri = $this->getForImport();
        foreach ($clientiOri as $cliente) {
            log_message('info', 'ClientiImportModel::getRecordsetForImport - Verifico cliente: ' . print_r($cliente, true));
            if (isset($mapClienti[$cliente->id_external])) {
                $cliente->id = $mapClienti[$cliente->id_external];
            
            } else {
                $cliente->id = null; // Nuovo cliente da importare
            }
        }
        //log_message('info', 'ClientiImportModel::getRecordsetForImport - Clienti originali: ' . print_r($clientiOri, true));
        /*$clienti = new \stdClass();
        foreach ($clientiOri as $cliente) {
            foreach($this->transcodingArray as $decodifica => $valore) {

                $cliente->{$decodifica} = $cliente->{$valore};
            }
        }*/
        log_message('info', 'ClientiImportModel::getRecordsetForImport - Clienti decodificati: ' . print_r($clientiOri, true));

        return $clientiOri;
    }

    public function importClienti()
    {
        $db = db_connect();
        $clienti = $this->getRecordsetForImport();
        $countUpdated = 0;
        $countImported = 0;
        foreach ($clienti as $cliente) {          
            //Imposto i valori di default per i campi mancanti a db sono not null
            $data = [
                'id' => $cliente->id, // Se esiste già, mantieni lo stesso ID
                'codice' => $cliente->codice_cliente ?: 'Mancante',
                'nome' => $cliente->nome ?: 'Mancante',
                'piva' => $cliente->piva,
                'indirizzo' => $cliente->indirizzo ?: 'Mancante',
                'citta' => $cliente->citta ?: 'Mancante',
                'cap' => $cliente->cap ?: 'N/A',
                'provincia' => $cliente->provincia ?: 'N/A',
                'telefono' => $cliente->telefono,
                'email' => $cliente->email,
                'id_external' => $cliente->id,
                'dt_import' => date('Y-m-d H:i:s'),
                'stato' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'utente_import' => auth()->id(),
            ];
            log_message('info', 'ClientiImportModel::importClienti - Importazione cliente: ' . print_r($data, true));
            if ($cliente->id) {
                $countUpdated++;
                // Aggiorna il cliente esistente
                $db->table('clienti')->update($data, ['id' => $cliente->id]);
            } else {
                $countImported++;
                // Inserisci un nuovo cliente
                $db->table('clienti')->insert($data);
            }            

        }
        return "Importati $countImported e aggiornati $countUpdated clienti.";
    }
}
