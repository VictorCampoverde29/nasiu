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

}