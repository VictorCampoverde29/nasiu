<?php
namespace App\Controllers;

use App\Models\EmpresaModel;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;

class LoginController extends Controller
{
    public function index()
    {
        $usuarios=new  UsuariosModel();
        $empresasCt=new EmpresaModel();
        $data['usuarios']=$usuarios->usuarios_activos();
        $data['empresas']=$empresasCt->get_empresas_activas();
        return view('login/login',$data);
    }
}