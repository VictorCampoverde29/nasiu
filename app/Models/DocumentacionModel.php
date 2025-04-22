<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentacionModel extends Model
{
    protected $table            = 'documentacion';
    protected $primaryKey       = 'iddocumentacion';
    protected $allowedFields    = [
        'idunidades',
        'descripcion',
        'numero',
        'fecha_vencimiento',
        'estado'
    ];

    public function get_all_vencidos()
    {
        $f_Actual = date('Y-m-d');
        return $this->select('unidades.descripcion as nombre_unidad,documentacion.descripcion as descripcion,documentacion.numero as numero,documentacion.fecha_vencimiento as fecha_vencimiento')
            ->where('fecha_vencimiento <', $f_Actual)
            ->join('unidades', 'documentacion.idunidades = unidades.idunidades')
            ->orderBy('fecha_vencimiento', 'ASC')
            ->findAll();
    }


    public function get_all_x_unidad($unidad)
    {
        return $this->where('idunidades', $unidad)
            ->orderBy('fecha_vencimiento', 'ASC')
            ->findAll();
    }


    public function exists($numero, $id = null)
    {
        $query = $this->where('numero', $numero);

        // Si se proporciona un ID, excluimos ese registro
        if ($id !== null) {
            $query->where('iddocumentacion !=', $id);
        }

        return $query->first() !== null;
    }
}
