<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AggiornamentiController extends BaseController
{
    protected $VersioniModel;
    protected $AggiornamentiModel;

    public function __construct()
    {
        $this->VersioniModel = new \App\Models\VersioniModel();
        $this->AggiornamentiModel = new \App\Models\AggiornamentiModel();
    }
    public function getByLicenza($idLicenza)
    {
        $aggiornamenti = $this->AggiornamentiModel->getByLicenza($idLicenza);
        log_message('info', 'AggiornamentiController::getByLicenza - Aggiornamenti ' . print_r($aggiornamenti, true));
        $data['aggiornamenti'] = $aggiornamenti;
        $data['title'] = 'Aggiornamenti per Licenza ' . esc($idLicenza);
        return view('aggiornamenti/tabAggiornamenti', $data);
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

        return view('aggiornamenti/form', $data);
    }

    public function salva($idLicenza = null) {
        // Se non è fornito un ID licenza, non posso salvare l'aggiornamento
        if ($idLicenza === null) {
            return redirect()->back()->with('error', 'Selezionare una licenza!.');
        }

        $data = $this->request->getPost();
        log_message('info', 'AggiornamentiController::salva - Dati ricevuti: ' . print_r($data, true));

        // Salvataggio dell'aggiornamento
        $this->AggiornamentiModel->save($data);
        $backTo = session()->get('backTo') ?? base_url('/clienti'); // Recupera il path di provenienza dalla sessione o usa un default'
        return redirect()->redirect($backTo)->with('success', 'Aggiornamento salvato con successo!');    
    }


    public function modifica($idAggiornamento) {}


    public function elimina($id) {}
    public function visualizza($id) {}
}
