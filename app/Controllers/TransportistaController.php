<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TransportistaModel;

class TransportistaController extends BaseController
{
    protected $transportistaModel;
    public function __construct() {
        $this->transportistaModel = new TransportistaModel();
    }
    public function index()
    {
        return view('transportista/index');
    }

    public function getAll()
    {
        $data=$this->transportistaModel->getAll();
        return $this->response->setJSON(['data'=>$data]);
    }

    public function getById()
    {
        $id = $this->request->getPost('id');
        $data=$this->transportistaModel->getById($id);
        return $this->response->setJSON(['data'=>$data]);
    }
     public function insertar()
    {
        
        $descripcion = $this->request->getPost('descripcion');    
        $estado = $this->request->getPost('estado');
        $ruc = $this->request->getPost('ruc');       
        $direcccion = $this->request->getPost('direccion');

     

        // Verificar si la descripción ya existe
        if ($this->transportistaModel->exists($ruc)) {
            return $this->response->setJSON(['error' => 'El Ruc ya existe.']);
        }

        $data = [
            'descripcion' =>  $descripcion,
            'estado' => $estado,
            'ruc' => $ruc,
            'direccion' => $direcccion
        ];


        try {
            // Inserta el transportista
            $this->transportistaModel->insert($data); // Guarda el artículo y obtiene el ID

            return $this->response->setJSON(['success' => true, 'message' => 'Transportista Agregado.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al agregar al Transportista: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
      
        $idtransportista = $this->request->getPost('cod'); // Obtener ID del artículo a actualizar
        $descripcion = $this->request->getPost('descripcion');    
        $estado = $this->request->getPost('estado');
        $ruc = $this->request->getPost('ruc');       
        $direcccion = $this->request->getPost('direccion');
        $data = [
            'descripcion' =>  $descripcion,
            'estado' => $estado,
            'ruc' => $ruc,
            'direccion' => $direcccion
        ];


        try {
            // Llama al método de actualización
            if ($this->transportistaModel->update($idtransportista, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Transportista Actualizado.']);
            } else {
                return $this->response->setJSON(['error' => 'Transportista no encontrado.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar al transportista: ' . $e->getMessage()]);
        }
    }
}
