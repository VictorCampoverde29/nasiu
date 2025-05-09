<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificadosModel extends Model
{
    protected $table            = 'certificados';
    protected $primaryKey       = 'idcertificados';  
    protected $allowedFields    = [
        'fecha_certificado',
        'modelo',
        'cilindridada',
        'potencia',
        'color',
        'año_modelo',
        'año_fabricacion',
        'version',
        'motor',
        'chasis',
        'expediente'];


    public function getCertificadosbyDate($startDate, $endDate)
    {
        return $this->where('fecha_certificado >=', $startDate)
                    ->where('fecha_certificado <=', $endDate)
                    ->findAll();
    }

    public function getCertificadoById($id)
    {
        return $this->where('idcertificados', $id)->first();
    }
    
}
