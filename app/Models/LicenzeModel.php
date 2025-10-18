<?php

namespace App\Models;

use CodeIgniter\Model;

class LicenzeModel extends Model
{
    protected $table            = 'licenze';
    protected $primaryKey       = 'id';
    protected $allowedFields = [
        'clienti_id',
        'codice',
        'figlio_sn',
        'padre_lic_id',
        'postazioni',
        'note',
        'tplicenze_id',
        'stato',
        'esistenza_cliente',
        'natura',
        'tipo',
        'modello',
        'created_at',
        'updated_at',
        'server',
        'conn',
        'ambiente',
        'nodo',
        'invii',
        'giga',
    ];
    protected $useTimestamps    = true;
    protected $returnType       = 'object';
    /**
     * Genera l'elenco delle licenze
     */
    //protected $afterFind = ['decodeLicenza'];

    public function __construct()
    {
        parent::__construct();
        helper('decoding'); // carica app/Helpers/decoding_helper.php
    }
    public function getLicenze()
    {

        return $this->select('*')
            ->orderBy('codice', 'ASC')
            ->findAll();
    }

    public function getLicenzeByCliente($idCliente)
    {
        log_message('info', 'Recupero le licenze per il cliente con ID: ' . $idCliente . 'e ottengo: ' . print_r($this->where('clienti_id', $idCliente)->findAll(), true));
        return $this->where('clienti_id', $idCliente)->findAll();
    }

    public function getLicenzeById($idLicenza)
    {   //Sto cercando per chiave primaria pertanto non serve il where
        return $this->find($idLicenza);
    }

    public function getLicenzeByTipo($tipoLicenza)
    {

        $idClientiPerLicenza = $this->select('clienti_id')
            ->distinct()
            ->where('tipo', $tipoLicenza)
            ->findAll();
        log_message('info', 'Clienti con licenza di tipo ' . $tipoLicenza . ': ' . print_r($idClientiPerLicenza, true));
        return $idClientiPerLicenza;
    }

    public function geTipoLicenzeByCliente()
    {
        $tipoLicenzaPerCliente = $this->select('clienti_id, tipo')
            ->distinct()
            ->findAll();
        log_message('info', 'tipoLicenzaPerCliente: ' . print_r($tipoLicenzaPerCliente, true));
        return $tipoLicenzaPerCliente;
    }
    public function salva($data)
    {

        log_message('info', 'Ricevo i seguenti dati nel MODEL: ' . print_r($data, true));

        return $this->save($data); // Restituisce l'ID della nuova licenza


    }
}
