<?php
namespace App\Models;

use CodeIgniter\Model;

class AlmacenModel extends Model
{
    protected $table      = 'almacen';
    protected $primaryKey = 'idalmacen';
    protected $allowedFields = ['idalmacen','descripcion'];
    public function get_almacenes_x_suc($codsucursal)
    {
        return $this->select('idalmacen,descripcion')
                    ->where('idsucursal',$codsucursal)
                    ->orderBy('descripcion','ASC')
                    ->findAll();
    }

    public function getAlmacen($codalmacen)
    {
        return $this->where('idalmacen',$codalmacen)
                    ->first();
    }
}