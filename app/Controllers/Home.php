<?php

namespace App\Controllers;

use App\Models\AccesoModel;

class Home extends BaseController
{
    public function index(): string
    {
        $AccesoModel=new AccesoModel();
        $version = env('VERSION');
        $codalmacen=session()->get('codigoalmacen');
        $data['version']=$version;
        $data['ventas']=$AccesoModel->get_datos_compras_ventas(2,$codalmacen);
        $data['compras']=$AccesoModel->get_datos_compras_ventas(1,$codalmacen);
        return view('dashboard/index',$data);
    }

    public function conversor()
    {
        $texto=$this->request->getPost('texto');
        if ($texto=='') {
            return $this->response->setJSON(['password:'=>'Necesita indicar el valor']);
            
        }
        else {
            $hashedPassword = password_hash($texto, PASSWORD_DEFAULT);
            return $this->response->setJSON(['password:'=>$hashedPassword]);
        }
       
    }
}
