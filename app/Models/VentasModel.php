<?php
namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'idventas';
    protected $allowedFields = ['iddocumento','importe_total'];

    
    public function getTotalVentasRegistradas($codAlmacen)
    {
        return $this->select("IFNULL(SUM(IF(iddocumento=7, importe_total * -1, importe_total)), 0) as total_ventas", false)
                ->where('estado', 'REGISTRADA')
                ->where('MONTH(fecha_emision)', 'MONTH(NOW())', false)
                ->where('YEAR(fecha_emision)', 'YEAR(NOW())', false)
                ->where('idalmacen', $codAlmacen)
                ->get()
                ->getRow()->total_ventas ?? 0;
    }
}