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

    public function __index()
    {
        $tipoLicenza = $this->request->getGet('tipoLicenza');
        if ($tipoLicenza) {
            $idClientiPerLicenza = $this->LicenzeModel->getLicenzeByTipo($tipoLicenza);
            log_message('info', 'Clienti con licenza di tipo ' . $tipoLicenza . ': ' . print_r($idClientiPerLicenza, true));
            $ids = array_map(fn($licenza) => $licenza->id_cli_ext, $idClientiPerLicenza);
            /*$ids = [];
            foreach ($idClientiPerLicenza as $licenza) {
                $ids[] = $licenza->id_cli_ext;
            }*/
            //$results = array_keys(array_column($idClientiPerLicenza, null, 'id_cli_ext'));
            if (count($idClientiPerLicenza) > 0) $data['clienti'] = $this->ClientiModel->getClientiByIds($ids);
            else $data['clienti'] = [];
            log_message('info', 'Clienti filtrati: ' . print_r($data['clienti'], true));
        } else {
            $data['clienti'] = $this->ClientiModel->getClienti();
        }
        $licenzeCount = $this->countLicenzeByCliente();

        foreach ($data['clienti'] as $cliente) {
            $cliente->numLicenze = $licenzeCount[$cliente->id] ?? 0;
        }
        $data['title'] = 'Elenco Clienti';

        return view('clienti/index', $data);
    }
    public function index()
    {

        $data['clienti'] = $this->ClientiModel->getClienti();
        $licenzeCount = $this->countLicenzeByCliente();
        $licenzeTipo = $this->getTipoLicenzeByCliente();
        log_message('info', 'Clienti: ' . print_r($data['clienti'], true));
        log_message('info', 'Licenze per tipo: ' . print_r($licenzeTipo, true));
        log_message('info', 'Conteggio licenze per cliente: ' . print_r($licenzeCount, true));


        foreach ($data['clienti'] as $cliente) {
            $cliente->numLicenze = $licenzeCount[$cliente->id] ?? 0;
            $cliente->tipiLicenze = isset($licenzeTipo[$cliente->id]) ? $licenzeTipo[$cliente->id] : [];
        }
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

    public function __clientiFilters()
    {
        $tipoLicenza = $this->request->getPost('tipoLicenza');
        echo "Tipo licenza selezionato: " . $tipoLicenza;
        /*if ($tipoLicenza) {
        }
        return view('clienti/form', [
            'mode' => 'view',
            'cliente' => $cliente,
            'action' => '',
            'title' => 'Dettagli Cliente ' . esc($cliente->nome),
        ]);*/
    }

    public function countLicenzeByCliente()
    {
        $rows =  $this->LicenzeModel
            ->select('id_cli_ext, COUNT(id) AS numLicenze')
            ->groupBy('id_cli_ext')
            ->findAll();
        $result = array_column($rows, 'numLicenze', 'id_cli_ext');
        return $result;
    }
    public function getTipoLicenzeByCliente()
    {
        $rows = $this->LicenzeModel->select('id_cli_ext, tipo')
            ->groupBy('id_cli_ext, tipo')
            ->get()
            ->getResultArray(); // array normale, nessuna indicizzazione su PK come in findAll()
        // Estraggo un array associativo con id_cli_ext come chiave e tipo come valore 
        $result = [];
        foreach ($rows as $row) {
            $result[$row['id_cli_ext']][] = $row['tipo'];
        }
        log_message('info', 'tipoLicenzaPerCliente: ' . print_r($result, true));
        return $result;
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
