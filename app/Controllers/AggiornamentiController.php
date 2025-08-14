<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AggiornamentiController extends BaseController
{
    protected $LicenzeModel;
    protected $ClientiModel;
    public function __construct()
    {
        $this->LicenzeModel = new \App\Models\LicenzeModel();
        $this->ClientiModel = new \App\Models\ClientiModel();
    }
    public function getByLicenza($idLicenza)
    {
        $aggModel = new \App\Models\AggiornamentiModel();
        return $aggModel->getByLicenza($idLicenza);
    }

    public function crea($idLicenza = null)
    {
        // Se non è fornito un ID licenza, non posso creare un aggiornamento
        if ($idLicenza === null) {
            return redirect()->back()->with('error', 'Selezionare una licenza!.');
        }

        $data['id_licenza'] = $idLicenza;
        $data['title'] = 'Crea Aggiornamento per Licenza ' . esc($idLicenza);

        return view('aggiornamenti/form', [
            'mode' => 'create',
            'action' => base_url('/aggiornamenti/salva/' . $idLicenza),
            'id_licenza' => $idLicenza,
            'aggiornamento' => null, // Non abbiamo un aggiornamento esistente da modificare
            'title' => $data['title'],
        ]);
    }

    public function salva($idLicenza = null) {}


    public function modifica($idAggiornamento) {}


    public function elimina($id) {}
    public function visualizza($id) {}
}
