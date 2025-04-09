<?php
namespace App\Controllers;

use App\Models\AccesoModel;
use CodeIgniter\Controller;
class AccesoController extends Controller
{
    public function get_empresas_acceso()
    {
        $AccesoModel=new AccesoModel();
        $usuario=session()->get('usuario');
        $data=$AccesoModel->get_empresas_acceso($usuario);
        return $this->response->setJSON(['empresas'=>$data]);
    }
}