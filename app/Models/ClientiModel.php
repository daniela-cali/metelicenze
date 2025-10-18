<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiModel extends Model
{


    protected $table            = 'clienti';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'codice',
        'nome',
        'piva',
        'indirizzo',
        'citta',
        'cap',
        'provincia',
        'telefono',
        'email',
        'note',
        'contatti',
        'id_external',
        'dt_import',
        'stato',
        'created_at',
        'updated_at',
        'utente_import',
    ];
    protected $returnType       = 'object';



    /**
     * Genera l'elenco di tutti i clienti
     */

    public function getClienti()
    {
        return $this->orderBy('nome', 'ASC')->findAll();
    }

    /**
     * Genera l'elenco dei clienti dato un array di ID
     */
    public function getClientiByIds($idClienti)
    {
        return $this->whereIn('id', $idClienti)->findAll();
    }

    /**
     * Recupera un cliente dato il suo ID
     */
    public function getInfoClienti()
    {
        return $this->select('id, nome')
            ->orderBy('nome', 'ASC')
            ->findAll();
    }

    public function getClientiById($id)
    {

        return $this->orderBy('nome', 'ASC')
            ->where('id', $id)
            ->first();
    }

}
