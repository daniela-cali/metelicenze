<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientiImportModel;

class ImportClientiController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Importa Clienti';
        $clientiModel = new ClientiImportModel();
        $data['clienti'] = $clientiModel->getRecordsetForImport();
        log_message('info', 'Clienti per importazione: ' . print_r($data['clienti'], true));

        return view('admin/importClienti', $data);
    }
    public function importClienti()
    {
        $clientiModel = new ClientiImportModel();
        $importedMessage = $clientiModel->importClienti();

        return redirect()->to('/admin/import_clienti')->with('success', $importedMessage);
    }
}
