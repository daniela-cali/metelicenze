<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientiModel;
use App\Models\LicenzeModel;
use CodeIgniter\HTTP\ResponseInterface;

class ClientiController extends BaseController
{

    protected $ClientiModel;
    protected $LicenzeModel;
    public function __construct()
    {
        $this->ClientiModel = new ClientiModel();
        $this->LicenzeModel = new LicenzeModel();
    }

    public function index()
    {


        $data['clienti'] = $this->ClientiModel->getClienti();
        $data['title'] = 'Elenco Clienti';

        return view('clienti/index', $data);
    }

    public function schedaCliente($id)
    {
        log_message('info', 'Path di provenienza:' . current_url());
        $session = session();
        $session->set('backTo', current_url()); // Salvo il path di provenienza nella sessione
        $data['cliente'] = $this->ClientiModel->getClientiById($id);
        $data['licenze'] = $this->LicenzeModel->getLicenzeByCliente($id);

        $data['title'] = 'Scheda Cliente';

        return view('clienti/schedaCliente', $data);
    }

    public function clientiFilters()
    {
        $tipoLicenza = $this->request->getPost('tipoLicenza');
        if ($tipoLicenza) {
            
        }


        return view('clienti/form', [
            'mode' => 'view',
            'cliente' => $cliente,
            'action' => '',
            'title' => 'Dettagli Cliente ' . esc($cliente->nome),
        ]);
    }
}

/*
tbana_ragsoc1
tbana_indirizzo1
tbana_citta
tbana_cap
tbana_provincia
tbana_telefono1
*/
