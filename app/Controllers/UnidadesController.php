<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnidadesModel;
use CodeIgniter\HTTP\ResponseInterface;

class UnidadesController extends BaseController
{
    public function index()
    {
        return view('unidades/index');
    }
    public function getall()
    {
        $unidadesModel = new UnidadesModel();
        $data = $unidadesModel->getAll();
        return $this->response->setJSON(['data' => $data]);
    }

    public function buscarxid()
    {
        $id = $this->request->getPost('id');
        $unidadesModel = new UnidadesModel();
        $data = $unidadesModel->getById($id);
        return $this->response->setJSON(['data' => $data]);
    }
    public function insertar()
    {
        $model = new UnidadesModel();
        $marca = $this->request->getPost('marca');
        $modelo = $this->request->getPost('modelo');
        $estado = $this->request->getPost('estado');
        $tonelaje = $this->request->getPost('tonelaje');
        $certificado = $this->request->getPost('cert');
        $categoria =  $this->request->getPost('categoria');
        $placa = $this->request->getPost('placa');
        $a_unid = $this->request->getPost('a_und');

        // Verificar si la descripción ya existe
        if ($model->exists($placa)) {
            return $this->response->setJSON(['error' => 'La placa ya existe.']);
        }

        $data = [
            'descripcion' => $this->request->getPost('marca') . ' ' . $this->request->getPost('placa'),
            'marca' => $marca,
            'modelo' => $modelo,
            'año_de_unidad' => $a_unid,
            'placa' => $placa,
            'estado' => $estado,
            'tonelaje' => $tonelaje,
            'cert_inscrip' => $certificado,
            'cvehicular' => $categoria
        ];


        try {
            // Inserta el artículo
            $idunidades = $model->insert($data); // Guarda el artículo y obtiene el ID

            return $this->response->setJSON(['success' => true, 'message' => 'Unidad Agregada.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al agregar la Unidad: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $model = new UnidadesModel();
        $idunidad = $this->request->getPost('cod'); // Obtener ID del artículo a actualizar
        $descripcion = $this->request->getPost('marca') . ' ' . $this->request->getPost('placa');
        $data = [
            'descripcion' => $descripcion,
            'marca' => $this->request->getPost('marca'),
            'modelo' => $this->request->getPost('modelo'),
            'año_de_unidad' => $this->request->getPost('a_und'),
            'placa' => $this->request->getPost('placa'),
            'estado' => $this->request->getPost('estado'),
            'tonelaje' => $this->request->getPost('tonelaje'),
            'cert_inscrip' => $this->request->getPost('cert'),
            'cvehicular' => $this->request->getPost('categoria')
        ];


        try {
            // Llama al método de actualización
            if ($model->update($idunidad, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Unidad Actualizada.']);
            } else {
                return $this->response->setJSON(['error' => 'Unidad no encontrado.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar la unidad: ' . $e->getMessage()]);
        }
    }
}
