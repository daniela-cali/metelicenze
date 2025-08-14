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
            'title' => 'Dettagli Licenza ' . esc($licenza->tblic_cd),
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

        
        $codice = $this->request->getGet('tblic_cd');
        $licenza = $this->LicenzeModel->getLicenzeById($idLicenza);
        $idCliente = $licenza->tblic_tbana_id;
        
        return view('licenze/form', [
            'mode' => 'edit',
            'licenza' => $licenza,
            'id_cliente' => $idCliente,
            'action' => base_url('/licenze/salva/' . $idCliente . '/' . $idLicenza), // Passo l'ID della licenza per la modifica
            'title' => 'Modifica Licenza ' . esc($codice) . ' (ID: ' . esc($idLicenza) . ')',
        ]);

        // Redirect o mostra un messaggio di successo
        return redirect()->to('clienti/schedaCliente/'.$idCliente);
    }
/**
 * 
     * Salva una licenza, sia che sia nuova o modificata
     * @param int|null $idLicenza ID della licenza da modificare o creare
     */
    public function salva($idCliente=null, $idLicenza= null)
    {
        // Se non è fornito un ID cliente, non posso salvare la licenza
        if ($idCliente === null) {
            return redirect()->back()->with('error', 'Selezionare un cliente!.');
        }
        $data = [
            'tblic_tbana_id' => $idCliente, // ID del cliente associato alla licenza
            'tblic_id_pk' => $idLicenza,
            'tblic_cd' => $this->request->getPost('codice'),
            'tblic_desc' => $this->request->getPost('descrizione'),
            'tblic_tp' => $this->request->getPost('tipologia'),
        ];

        // Se l'ID della licenza è fornito, aggiorno la licenza esistente
        if ($idLicenza !== null) {
            $data['tblic_id_pk'] = $idLicenza; // Aggiungo l'ID della licenza
        } else {
            // Se non è fornito un ID, creo una nuova licenza
            $data['tblic_id_pk'] = null; // Imposto a null per creare una nuova licenza
        }

        // Salvo la licenza nel database
        $this->LicenzeModel->salva($data);

        // Redirect o mostra un messaggio di successo
        return redirect()->to('clienti/schedaCliente/' . $idCliente)->with('success', 'Licenza salvata con successo.');
    }
    /**
     * Crea una nuova licenza per un cliente specifico
     * @param int $idCliente ID del cliente per cui creare la licenza
     */
    /**public function nuovaByCliente($idCliente)
    {
        // Se non è fornito un ID cliente, non posso salvare la licenza
        if ($idCliente === null) {
            return redirect()->back()->with('error', 'Selezionare un cliente!.');
        }


        $data = [
            'tblic_tbana_id' => $idCliente, 
            'tblic_cd' => $this->request->getPost('codice'),
            'tblic_desc' => $this->request->getPost('descrizione'),
            'tblic_tp' => $this->request->getPost('tipologia'),
            'tblic_stato' => 't', // Imposta lo stato iniziale come attivo
            'tblic_id_pk' => null, // Imposto a null per creare una nuova licenza
        ];


        // Salvo la licenza nel database
        $this->LicenzeModel->salva($data);

        // Redirect o mostra un messaggio di successo
        return redirect()->to('clienti/schedaCliente/' . $idCliente)->with('success', 'Licenza salvata con successo.');
    }**/


    public function elimina($idLicenza)
    {
        // Logica per eliminare una licenza
        $this->LicenzeModel->delete($idLicenza);
        // Redirect o mostra un messaggio di successo
        return redirect()->back()->with('success', 'Licenza eliminata con successo.');
    }

    public function jsonByLicenza($idLicenza)
{
    $aggModel = new \App\Models\AggiornamentiModel();
    $aggiornamenti = $aggModel->getByLicenza($idLicenza);

    return $this->response->setJSON($aggiornamenti);
}
}
