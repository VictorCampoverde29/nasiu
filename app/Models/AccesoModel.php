<?php

namespace App\Models;

use CodeIgniter\Model;

class AccesoModel extends Model
{
    protected $table      = 'acceso acc';
    protected $primaryKey = 'idacceso';
    protected $allowedFields = ['idusuarios','idsucursal','acceso'];

    public function get_empresas_acceso($usuario){
        $fecha_actual=date('Y-m-d');
        return $this->distinct()
                    ->select('emp.idempresa,emp.descripcion')
                    ->join('sucursal suc','acc.idsucursal=suc.idsucursal')
                    ->join('empresa emp','suc.idempresa=emp.idempresa')
                    ->where('acceso','SI')
                    ->where('emp.estado','ACTIVO')
                    ->where('acc.idusuarios',$usuario)
                    ->where('emp.venc_crt >=',$fecha_actual)
                    ->orderby('emp.descripcion','ASC')
                    ->findAll();
    }

    public function get_datos_compras_ventas($tipo,$codalma)
    {
        $sql = 'CALL VER_ARTICULOS_KARDEX_GENERAL(?, ?)';
        $query = $this->db->query($sql, [
            
            $codalma,
            $tipo
        ]);    
        return $query->getResultArray(); // Retorna los resultados como un array
    }

    
}