<?php 

namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model
{
    protected $table      = 'sucursal';
    protected $primaryKey = 'idsucursal';
    protected $allowedFields = ['idsucursal','descripcion','estado','idempresa'];

    public function get_sucursal_activas($cod)
    {
        return $this->select('idsucursal,descripcion')
                    ->where('estado','ACTIVO')
                    ->where('idempresa',$cod)
                    ->orderBy('descripcion','ASC')
                    ->findAll();
    }

}