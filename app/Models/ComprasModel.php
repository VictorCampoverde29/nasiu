<?php
namespace App\Models;

use CodeIgniter\Model;

class ComprasModel extends Model
{
    protected $table      = 'compras';
    protected $primaryKey = 'idcompras';

    protected $allowedFields = [];

    public function getTotalComprasMesActual()
    {
        $codalmacen=session()->get('codalmacen');
        if ($codalmacen) {
            $result = $this->select('IFNULL(SUM(imp_total), 0) as TOT_COMPRAS')
            ->where('estado', 'REGISTRADA')
            ->where('MONTH(fecha_emision)', 'MONTH(CURRENT_DATE())')
            ->where('YEAR(fecha_emision)', 'YEAR(CURRENT_DATE())')
            ->where('idalmacen', $codalmacen)
            ->get();
            $montomes=$result->getRow()->TOT_COMPRAS ?? 0;
        }
        else{$montomes=0;}      
        
        return (float)($montomes);
    }

    public function getTotalComprasRegistradas($codAlmacen)
    {
        return $this->select("IFNULL(SUM(IF(iddocumento=7, imp_total * -1, imp_total)), 0) as tot_compras", false)
                   ->where('estado', 'REGISTRADA')
                   ->where('MONTH(fecha_emision)', 'MONTH(NOW())', false)
                   ->where('YEAR(fecha_emision)', 'YEAR(NOW())', false)
                   ->where('idalmacen', $codAlmacen)
                   ->get()
                   ->getRow()->tot_compras ?? 0;
    }
}