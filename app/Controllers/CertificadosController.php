<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CertificadosController extends BaseController
{
    public function imp_cert()
    {
        return view('certificados/imp_cert');
    }
}
