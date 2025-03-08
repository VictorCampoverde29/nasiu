<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
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
