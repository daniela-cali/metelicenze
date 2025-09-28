<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
helper('decoding');
class LicenzeController extends BaseController
{
    protected $LicenzeModel;
    protected $AggiornamentiModel;
    protected $ClientiModel;
    public function __construct()
    {
        $this->LicenzeModel = new \App\Models\LicenzeModel();
        $this->AggiornamentiModel = new \App\Models\AggiornamentiModel();
        $this->ClientiModel = new \App\Models\ClientiModel();
    }

    public function index()
    {

        $licenze = $this->LicenzeModel->getLicenze();
        $clienti = $this->ClientiModel->getInfoClienti();
        $aggiornamenti = $this->AggiornamentiModel->getLastAggiornamenti();
        log_message('info', 'LicenzeController::Aggiornamenti recenti: ' . print_r($aggiornamenti, true));
        foreach ($licenze as $licenza) {
            // Trova il cliente corrispondente per ogni licenza
            $cliente = array_filter($clienti, fn($c) => $c->id === $licenza->id_cli_ext);
            $ultimo_agg = array_filter($aggiornamenti, fn($a) => $a->licenza_id === $licenza->id);
            $licenza->clienteNome = $cliente ? array_values($cliente)[0]->nome : 'Cliente non trovato';
            $licenza->clienteId = $cliente ? array_values($cliente)[0]->id : null;           
            $licenza->ultimoAggiornamento = $ultimo_agg ? array_values($ultimo_agg)[0]->ultimo_aggiornamento : 'N/A';
            $licenza->versioneUltimoAggiornamento = $ultimo_agg ? array_values($ultimo_agg)[0]->versione_codice : 'N/A';
            
            /**
             * Commento in quanto ho cambiato il tipo in enum nel database
             */
            //$licenza->tipo = decodingTipo($licenza->tipo);
            //$licenza->modello = decodingModello($licenza->modello);
        }
        $data['licenze'] = $licenze;
        $data['title'] = 'Elenco Licenze';

        return view('licenze/index', $data);
    }


    public function visualizza($idLicenza)
    {
        // Logica per visualizzare i dettagli di una licenza
        $licenza = $this->LicenzeModel->getLicenzeById($idLicenza);

        return view('licenze/form', [
            'mode' => 'view',
            'licenza' => $licenza,
            'action' => '',
            'title' => 'Dettagli Licenza ' . esc($licenza->codice),
        ]);
    }

    public function crea($idCliente = null)
    {

        /** 
         * Se non è fornito un ID cliente, non posso salvare la licenza
         * Pertanto si può creare una licenza solo dalla scheda cliente
         * */

        if ($idCliente === null) {
            return redirect()->back()->with('error', 'Selezionare un cliente!.');
        }

            $data['mode'] = 'create';
            $data['action'] = base_url('/licenze/salva/' . $idCliente); //Essendo nel crea la licenza non ha ancora ID
            $data['id_cliente'] = $idCliente;
            $data['cliente'] = $this->ClientiModel->getClientiById($idCliente);
            $data['licenza'] = null; 
            $data['title'] = 'Crea Licenza per Cliente ' . esc($data['cliente']->nome) . ' [ID: ' . esc($idCliente) . ']';


        return view('licenze/form', $data);
    }

    public function modifica($idLicenza)
    {
        // Logica per modificare una licenza


        $licenza = $this->LicenzeModel->getLicenzeById($idLicenza);
        $idCliente = $licenza->id_cli_ext; // Ottengo l'ID del cliente associato alla licenza
        $codice =  $licenza->codice;
        //$backTo = 
        $data = [
            'licenza' => $licenza,
            'id_cliente' => $idCliente,
            'mode' => 'edit',
            'title' => 'Modifica Licenza ' . esc($codice) . ' (ID: ' . esc($idLicenza) . ')',
            'action' => base_url('/licenze/salva/' . $idCliente . '/' . $idLicenza),
        ];

        return view('licenze/form', [
            'mode' => 'edit',
            'licenza' => $licenza,
            'id_cliente' => $idCliente,
            'action' => base_url('/licenze/salva/' . $idCliente . '/' . $idLicenza), // Passo l'ID della licenza per la modifica
            'title' => 'Modifica Licenza ' . esc($codice) . ' (ID: ' . esc($idLicenza) . ')',
        ]);

        // Redirect o mostra un messaggio di successo
        return redirect()->to('clienti/schedaCliente/' . $idCliente);
    }
    /**
     * 
     * Salva una licenza, sia che sia nuova o modificata
     * @param int|null $idLicenza ID della licenza da modificare o creare
     */
    public function salva($idCliente = null, $idLicenza = null)
    {
        // Se non è fornito un ID cliente, non posso salvare la licenza
        $data = $this->request->getPost(); // Prende tutti i campi del form
        log_message('info', 'Ricevo questi dati nel CONTROLLER: ' . print_r($data, true));
        $stato = $this->request->getPost('stato') ? 1 : 0; // Converte lo stato in booleano
        $data['stato'] = $stato; // Aggiungo lo stato al
        if ($idCliente === null) {
            return redirect()->back()->with('error', 'Selezionare un cliente!.');
        } else {
            $data['id_cli_ext'] = $idCliente; // Associa la licenza al cliente
        }
        if ($idLicenza !== null) {
            $data['id'] = $idLicenza; // Se sto modificando, aggiungo l'ID della licenza
        }
        log_message('info', 'Ricevo questo idcliente: ' . $idCliente . ' e idlicenza: ' . $idLicenza);
        log_message('info', 'Data contiene questo prima di inviare al model ->salva: ' . print_r($data, true));
        // Salvo la licenza nel database
        $this->LicenzeModel->salva($data);

        // Redirect o mostra un messaggio di successo
        return redirect()->to('clienti/schedaCliente/' . $idCliente)->with('success', 'Licenza salvata con successo.');
    }

    public function elimina($idLicenza)
    {
        // Logica per eliminare una licenza
        $this->LicenzeModel->delete($idLicenza);
        // Redirect o mostra un messaggio di successo
        return redirect()->back()->with('success', 'Licenza eliminata con successo.');
    }
}
