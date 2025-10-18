<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiImportModel extends Model
{

    protected $table            = 'clienti';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields = [
      'codice', 
       'nome', 
       'piva', 
       'indirizzo', 
       'citta', 
       'cap', 
       'provincia', 
       'telefono', 
       'email', 
       'note', 
       'contatti', 
       'id_external', 
       'dt_import', 
       'stato', 
       'created_at', 
       'updated_at', 
       'utente_import', 
 ];



    public function getClientiOri()
    {
        $clientiExternalModel = new ClientiExternalModel();
        $clienti = $clientiExternalModel->getTranscodedClienti();
        log_message('info', 'ClientiImportModel::getClientiOri - Clienti originali: ' . print_r($clienti, true));
        return $clienti;
    }

    public function getRecordsetForImport()
    {
        $clienti = $this->getClientiOri();

        $clientiIDs = $this->select(['id', 'id_external'])
            ->get()
            ->getResult();
        log_message('info', 'ClientiImportModel::getRecordsetForImport - clientiIDs: ' . print_r($clientiIDs, true));

        $mapClienti = [];

        foreach ($clientiIDs as $value) {
            $mapClienti[$value->id_external] = $value->id;
        }
        log_message('info', 'ClientiImportModel::getRecordsetForImport - mapClienti: ' . print_r($mapClienti, true));
        foreach ($clienti as $cliente) {
            if (isset($mapClienti[$cliente->id_external])) {
                $cliente->id = $mapClienti[$cliente->id_external]; //Asegno ID esistente
            } else {
                $cliente->id = null; // Nuovo cliente da importare
            }
            log_message('info', 'ClientiImportModel::getRecordsetForImport - Verifico cliente: ' . print_r($cliente, true));
        }

        return $clienti;
    }

    public function importClienti()
    {

        $clienti = $this->getRecordsetForImport();
        $countImported = 0;
        $countUpdated = 0;

        foreach ($clienti as $cliente) {
            //Imposto i valori di default per i campi mancanti a db sono not null
            if (empty($cliente->id)) {
                $countImported++; // Se ID è vuoto, è un nuovo cliente                
            } else {
                $countUpdated++; // Altrimenti è un aggiornamento
            }
            $data = [
                'id' => $cliente->id, // Se esiste già, mantiene lo stesso ID
                'codice' => $cliente->codice?: 'Mancante',
                'nome' => $cliente->nome ?: 'Mancante',
                'piva' => $cliente->piva,
                'indirizzo' => $cliente->indirizzo ?: 'Mancante',
                'citta' => $cliente->citta ?: 'Mancante',
                'cap' => $cliente->cap ?: 'N/A',
                'provincia' => $cliente->provincia ?: 'N/A',
                'telefono' => $cliente->telefono,
                'email' => $cliente->email,
                'id_external' => $cliente->id_external,
                'dt_import' => date('Y-m-d H:i:s'),
                'stato' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'utente_import' => auth()->id(),
            ];
            
            $this->save($data);

        }
        return "Importati $countImported clienti e aggiornati $countUpdated clienti.";
    }
}
