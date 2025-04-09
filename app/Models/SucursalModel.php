<?php 

namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model
{
    protected $table      = 'sucursal suc';
    protected $primaryKey = 'idsucursal';
    protected $allowedFields = ['idsucursal','descripcion','estado','direccion','idempresa','est_anexo'];

    public function get_sucursal_activas($cod)
    {
        return $this->select('idsucursal,descripcion')
                    ->where('estado','ACTIVO')
                    ->where('idempresa',$cod)
                    ->orderBy('descripcion','ASC')
                    ->findAll();
    }

    public function getSucursal($cod)  {
        return $this->select('suc.descripcion as suc_descripcion,emp.descripcion as descripcion_emp,suc.direccion as direccion_suc,
                            est_anexo,emp.direccion as direccion_emp,ruc,emp.idempresa,modo_ft_notas,modo_guias,
                            usuario_sol,clavesol,clientid,passid')
                            ->join('empresa emp','suc.idempresa=emp.idempresa')
                            ->where('idsucursal',$cod)
                            ->first();
    }

}