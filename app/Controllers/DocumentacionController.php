<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentacionModel;
use CodeIgniter\HTTP\ResponseInterface;

class DocumentacionController extends BaseController
{
    public function get_all_x_unidades()
    {
        $codunidad = $this->request->getPost('id');
        $DocumentacionModel=new DocumentacionModel();
        $data = $DocumentacionModel->get_all_x_unidad($codunidad);
        return $this->response->setJSON(['data' => $data]);
    }
    public function get_all_vencidos()
    {

        $DocumentacionModel=new DocumentacionModel();
        $data = $DocumentacionModel->get_all_vencidos();
        return $this->response->setJSON(['data' => $data]);
    }
    
    public function insertar()
    {
        $model = new DocumentacionModel();     
        $unidades=$this->request->getPost('unidades');
        $descripcion = $this->request->getPost('descripcion');
        $numero = $this->request->getPost('numero');
        $fvencimiento = $this->request->getPost('fecha_vencimiento');

        // Verificar si la descripción ya existe
        if ($model->exists($numero)) {
            return $this->response->setJSON(['error' => 'El numero ya existe.']);
        }
        $data = [
            'idunidades' => $unidades,
            'descripcion' => $descripcion,
            'numero' => $numero,
            'fecha_vencimiento' => $fvencimiento,
            'estado' => 'ACT'
        ];
    
  
        try {
            // Inserta el artículo
            $idunidades = $model->insert($data); // Guarda el artículo y obtiene el ID
  
            return $this->response->setJSON(['success' => true, 'message' => 'Documentación Agregada.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al agregar la Documentación: ' . $e->getMessage()]);
        }
    }
  
    public function update()
    {
        $model = new DocumentacionModel();
        $iddocumentacion = $this->request->getPost('cod'); // Obtener ID del artículo a actualizar
        $descripcion = $this->request->getPost('descripcion');
        $numero = $this->request->getPost('numero');
        $fvencimiento = $this->request->getPost('fecha_vencimiento');
        $data = [
          
            'descripcion' => $descripcion,
            'numero' => $numero,
            'fecha_vencimiento' => $fvencimiento
        ];
        log_message('error', 'DATA: ' . print_r($data, true));
  
        try {
            // Llama al método de actualización
            if ($model->update($iddocumentacion, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Documentación Actualizada.']);
            } else {
                return $this->response->setJSON(['error' => 'Documentación no encontrada.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar la documentación: ' . $e->getMessage()]);
        }
    }
}
