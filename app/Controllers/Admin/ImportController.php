<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientiModel;

class ImportController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Importa Dati';
        $clientiModel = new ClientiModel();
        $data['clienti'] = $clientiModel->getForImport();
        log_message('info', 'Clienti per importazione: ' . print_r($data['clienti'], true));

        return view('admin/import', $data);
    }
}
