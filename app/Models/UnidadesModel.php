<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadesModel extends Model
{
    protected $table            = 'unidades';
    protected $primaryKey       = 'idunidades';

    protected $allowedFields    = [
        'descripcion',
        'marca',
        'modelo',
        'año_de_unidad',
        'placa',
        'estado',
        'tonelaje',
        'cert_inscrip',
        'cvehicular'
    ];

  public function getAll(){
    return $this->orderBy('descripcion','ASC')
                ->findAll();
  }
  public function getById($id){
    return $this->where('idunidades',$id)
                ->first();
  }

  public function exists($placa, $id = null)
  {
      $query = $this->where('placa', $placa);
      
      // Si se proporciona un ID, excluimos ese registro
      if ($id !== null) {
          $query->where('idunidades !=', $id);
      }

      return $query->first() !== null;
  }

  
}
