<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LicenzeController extends BaseController
{
    protected $LicenzeModel;
    protected $ClientiModel;
    public function __construct()
    {
        $this->LicenzeModel = new \App\Models\LicenzeModel();
        $this->ClientiModel = new \App\Models\ClientiModel();
    }

    public function index()
    {
        $data['licenze'] = $this->LicenzeModel->getLicenze();
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

        // Se non è fornito un ID cliente, non posso salvare la licenza
        if ($idCliente === null) {
            return redirect()->back()->with('error', 'Selezionare un cliente!.');
        }

        $data['id_cliente'] = $idCliente;
        $data['title'] = 'Crea Licenza per IDCliente ' . esc($idCliente);



        return view('licenze/form', [
            'mode' => 'create',
            'action' => base_url('/licenze/salva/' . $idCliente), //Essendo nel crea la licenza non ha ancora ID
            'id_cliente' => $idCliente,
            'licenza' => null, // Non abbiamo una licenza esistente da modificare
            'title' => $data['title'],
        ]);
    }

    public function modifica($idLicenza)
    {
        // Logica per modificare una licenza


        $licenza = $this->LicenzeModel->getLicenzeById($idLicenza);
        $idCliente = $licenza->id_cli_ext; // Ottengo l'ID del cliente associato alla licenza
        $codice =  $licenza->codice;

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
