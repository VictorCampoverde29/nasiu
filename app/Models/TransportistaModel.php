<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportistaModel extends Model
{
    protected $table            = 'transportista';
    protected $primaryKey       = 'idtransportista';
    protected $allowedFields    = ['descripcion',
        'estado',
        'ruc',
        'direccion'];

 
    public function getAll()
    {
        return $this->where('ruc!=','-')
                    ->findAll();
    }

    public function getById($id)
    {
        return $this->where('idtransportista',$id)
                    ->first();
    }
    public function exists($ruc, $id = null)
    {
        $query = $this->where('ruc', $ruc);
        
        // Si se proporciona un ID, excluimos ese registro
        if ($id !== null) {
            $query->where('idtransportista !=', $id);
        }

        return $query->first() !== null;
    }
}
