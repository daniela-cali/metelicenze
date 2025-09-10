<?php

namespace App\Models;

use CodeIgniter\Model;

class LicenzeModel extends Model
{
    protected $table            = 'licenze';
    protected $primaryKey       = 'id';
    protected $allowedFields = [
        'id_cli_ext',
        'codice',
        'figlio_sn',
        'padre_lic_id',
        'postazioni',
        'note',
        'tplicenze_id',
        'stato',
        'esistenza_cliente',
        'natura',
        'descrizione',
        'tipo',
        'modello',
    ];
    protected $useTimestamps    = true;
    protected $returnType       = 'object';
    /**
     * Genera l'elenco delle licenze
     */
    public function getLicenze()
    {
        return $this->select('*')
            ->orderBy('codice', 'ASC')
            ->findAll();
    }

    public function getLicenzeByCliente($idCliente)
    {
        return $this->where('id_cli_ext', $idCliente)->findAll();
    }

    public function getLicenzeById($idLicenza)
    {   //Sto cercando per chiave primaria pertanto non serve il where
        return $this->find($idLicenza);
    }
    public function getLicenzeByTipo($tipoLicenza)
    {

        $idClientiPerLicenza = $this->select('id_cli_ext')
            ->distinct()
            ->where('tipo', $tipoLicenza)
            ->findAll();
        log_message('info', 'Clienti con licenza di tipo ' . $tipoLicenza . ': ' . print_r($idClientiPerLicenza, true));
        return $idClientiPerLicenza;
            
    }
    public function salva($data)
    {

        log_message('info', 'Ricevo i seguenti dati nel MODEL: ' . print_r($data, true));

        return $this->save($data); // Restituisce l'ID della nuova licenza


    }
}
