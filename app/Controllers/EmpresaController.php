<?php
namespace App\Controllers;

use App\Models\EmpresaModel;
use CodeIgniter\Controller;


class EmpresaController extends Controller
{
    public function index()
    {
        return view('empresa/index');
    }

    public function ver_empresas_activas()
    {
        $empresaModel=new EmpresaModel();
        $data=$empresaModel->get_empresas_activas();
        return $this->response->setJSON(['data'=>$data]);
    }
}