<?php

namespace App\Models;

use CodeIgniter\Model;

class AggiornamentiModel extends Model
{
    protected $table            = 'aggiornamenti';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'licenze_id',
        'versioni_id',
        'note',
        'dt_agg',
        'stato',
    ];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getByLicenza($id_licenza)
    {
        log_message('info', 'AggiornamentiModel::getByLicenza - ID Licenza: ' . $id_licenza);
        return $this->where('licenze_id', $id_licenza)
            ->orderBy('dt_agg', 'DESC')
            ->findAll();
    }
}
