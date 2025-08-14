<?php

namespace App\Models;

use CodeIgniter\Model;

class LicenzeModel extends Model
{
    protected $table            = 'nrg.tblic';
    protected $primaryKey       = 'tblic_id_pk';
    protected $allowedFields    = [
        'tblic_id_pk',
        'tblic_cd',
        'tblic_tp',
        'tblic_natura',
        'tblic_desc',
        'tblic_tbana_id',
        'tblic_stato'
    ];

    protected $returnType       = 'object';
    /**
     * Genera l'elenco delle licenze
     */
    public function getLicenze()
    {
        return $this->select([
            'tblic_cd as nome_licenza',
            'tblic_id_pk as id',
            'tblic_tp as tipo',
            'tblic_natura as natura',
            'tblic_desc as descrizione',
            'tblic_tbana_id as id_cliente',
            'tblic_stato as stato'

        ])
            ->orderBy('tblic_cd', 'ASC')
            ->findAll();
    }

    public function getLicenzeByCliente($idCliente)
    {
        return $this->where('tblic_tbana_id', $idCliente)->findAll();
    }

    public function getLicenzeById($idLicenza)
    {   //Sto cercando per chiave primaria pertanto non serve il where
        return $this->find($idLicenza);
    }

    public function salva($data)
    {
        log_message('info', 'Ricevo i seguenti dati: ' . json_encode($data));
        if (isset($data['tblic_id_pk'])) {
            // Se l'ID è presente, aggiorna la licenza esistente
            $this->update($data['tblic_id_pk'], $data);
            return $data['tblic_id_pk']; // Restituisce l'ID della licenza aggiornata
        } else {
            // Altrimenti, crea una nuova licenza
            // Recupero il prossimo ID per la licenza
            $nextId = null;
            $query = $this->query("SELECT nextval('nrg.s_tblic_id') AS next_id");
            $nextId = $query->getRow()->next_id;
            log_message('info', 'e aggiungo il prossimo ID per la licenza: ' . $nextId);
            $data['tblic_id_pk'] = $nextId; // Imposto il nuovo ID nella licenza
            $data['tblic_stato'] = 't'; // Imposto lo stato iniziale come attivo
            log_message('info', 'Dati della licenza da inserire: ' . json_encode($data));
            return $this->insert($data); // Restituisce l'ID della nuova licenza
        }

    }
}
