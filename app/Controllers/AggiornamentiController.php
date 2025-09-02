<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AggiornamentiController extends BaseController
{
    protected $VersioniModel;
    protected $AggiornamentiModel;
    protected $backTo;

    public function __construct()
    {
        $this->VersioniModel = new \App\Models\VersioniModel();
        $this->AggiornamentiModel = new \App\Models\AggiornamentiModel();
        $this->backTo = session()->get('backTo') ?? base_url('/clienti'); // Recupera il path di provenienza dalla sessione o usa un default
    }

    public function getByLicenza($idLicenza)
    {

        $aggiornamenti = $this->AggiornamentiModel->getByLicenza($idLicenza);

        //log_message('info', 'AggiornamentiController::getByLicenza - Aggiornamenti ' . print_r($aggiornamenti, true));
        $data['aggiornamenti'] = $aggiornamenti;
        $data['title'] = 'Aggiornamenti per Licenza ' . esc($idLicenza);
        //log_message('info', 'Data prima della view ' . print_r($data, true));
        return view('aggiornamenti/tabAggiornamenti', $data);
    }
   public function visualizza($idAggiornamento)
    {
        // Logica per visualizzare i dettagli di una licenza
        $aggiornamento = $this->AggiornamentiModel->getById($idAggiornamento);
        $versioni = $this->VersioniModel->getVersioni();

        $data['aggiornamento'] = $aggiornamento;
        $data['title'] = 'Dettagli aggiornamento del ' . date('d/m/Y', strtotime($aggiornamento->dt_agg));
        $data['versioni'] = $versioni;
        $data['action'] = '' ; // Non c'è azione di salvataggio in visualizzazione
        $data['mode'] = 'view'; 
        $data['backTo'] = $this->backTo; // Aggiungo il path di provenienza per il bottone indietro 

        return view('aggiornamenti/form', $data);
    }
    public function crea($idLicenza = null)
    {
        // Se non è fornito un ID licenza, non posso creare un aggiornamento
        if ($idLicenza === null) {
            return redirect()->back()->with('error', 'Selezionare una licenza!.');
        }

        $versioni = $this->VersioniModel->getVersioni();
        $data['licenze_id'] = $idLicenza;
        $data['title'] = 'Crea Aggiornamento per Licenza ID' . esc($idLicenza);
        $data['versioni'] = $versioni;
        $data['action'] = base_url('/aggiornamenti/salva/' . $idLicenza); // Azione per il salvataggio dell'aggiornamento
        $data['mode'] = 'create'; // Modalità di creazione
        $data['aggiornamento'] = null; // Non abbiamo un aggiornamento esistente da modificare
        $data['backTo'] = $this->backTo; // Aggiungo il path di provenienza per il bottone indietro 

        return view('aggiornamenti/form', $data);
    }

    public function salva($idLicenza = null) {

        $data = $this->request->getPost(); // Prende tutti i campi del form
        $stato = $this->request->getPost('stato') ? 1 : 0; // Converte lo stato in booleano
        $data['stato'] = $stato; // Aggiungo lo stato al
        // Se non è fornito un ID licenza, non posso salvare l'aggiornamento
        if ($idLicenza === null) {
            return redirect()->back()->with('error', 'Selezionare una licenza!.');
        }
        

  
        log_message('info', 'AggiornamentiController::salva - Dati ricevuti e modificato lo stato: ' . print_r($data, true));

        // Salvataggio dell'aggiornamento
        $this->AggiornamentiModel->save($data);
        $backTo = session()->get('backTo') ?? base_url('/clienti'); // Recupera il path di provenienza dalla sessione o usa un default'
        return redirect()->redirect($this->backTo)->with('success', 'Aggiornamento salvato con successo!');    
    }


    public function modifica($idAggiornamento) {

        $aggiornamento = $this->AggiornamentiModel->getById($idAggiornamento);
        $versioni = $this->VersioniModel->getVersioni();

        $data['aggiornamento'] = $aggiornamento;
        $data['title'] = 'Modifica aggiornamento del ' . date('d/m/Y', strtotime($aggiornamento->dt_agg));
        $data['versioni'] = $versioni;
        $data['action'] = base_url('/aggiornamenti/salva/' . $idAggiornamento);
        $data['mode'] = 'edit'; 
        $data['backTo'] = $this->backTo; // Aggiungo il path di provenienza per il bottone indietro 

        return view('aggiornamenti/form', $data);

    }


    public function elimina($idAggiornamento)
    {
        // Logica per eliminare una licenza
        $this->AggiornamentiModel->delete($idAggiornamento);
        // Redirect o mostra un messaggio di successo
        return redirect()->redirect($this->backTo)->with('success', 'Aggiornamento eliminato con successo.');
    }
}
