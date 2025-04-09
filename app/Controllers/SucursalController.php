<?php

namespace App\Controllers;

use App\Models\SucursalModel;
use CodeIgniter\Controller;
class SucursalController extends Controller
{
   

    public function get_sucursal_activas()
    {
        $sucModel=new SucursalModel();
        $codEmpresa=$this->request->getPost('cod');
        $data=$sucModel->get_sucursal_activas($codEmpresa);
        return $this->response->setJSON(['sucursales'=>$data]);
    }
}