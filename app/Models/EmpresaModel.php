<?php
namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresa';
    protected $primaryKey = 'idempresa';
    protected $allowedFields = ['idempresa','descripcion'];

    public function get_empresas_activas()
    {
        return $this->select('idempresa,CONCAT(ruc,"-",descripcion) as nombre')
                    ->where('estado','ACTIVO')
                    ->orderBy('descripcion','ASC')
                    ->findAll();
    }
}