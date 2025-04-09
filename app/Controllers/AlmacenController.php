<?php
namespace App\Controllers;

use App\Models\AlmacenModel;
use CodeIgniter\Controller;
class AlmacenController extends Controller
{
    public function get_almacenes_x_suc()
    {
        $almacenMdl=new AlmacenModel();
        $codsucursal=$this->request->getPost('cod');
        $data =$almacenMdl->get_almacenes_x_suc($codsucursal);
        return $this->response->setJSON(['almacenes'=>$data]);
    }
}