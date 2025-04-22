<?php

namespace App\Controllers;

use App\Models\AccesoModel;
use App\Models\ComprasModel;
use App\Models\VentasModel;

class Home extends BaseController
{
    public function index(): string
    {
        $AccesoModel=new AccesoModel();
        $comprasModel=new ComprasModel();
        $ventasModel=new VentasModel();
        $version = env('VERSION');
        $codalmacen=session()->get('codigoalmacen');
        $data['version']=$version;
        $rawVentas=$AccesoModel->get_datos_compras_ventas(2,$codalmacen);
        $rawCompras=$AccesoModel->get_datos_compras_ventas(1,$codalmacen);

         // Formatear datos para el gráfico
        $data['compras'] = $this->formatMonthlyData($rawCompras);
        $data['ventas'] = $this->formatMonthlyData($rawVentas);
  
       
        $data['mtocompras']=$comprasModel->getTotalComprasRegistradas($codalmacen);
        $data['mtoventas']=$ventasModel->getTotalVentasRegistradas($codalmacen);
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
    private function formatMonthlyData(array $data): array
    {
        $monthlyData = array_fill(1, 12, 0); // Meses 1-12 con valor 0

        foreach ($data as $row) {
            $month = (int)$row['mes'];
            $monthlyData[$month] = (float)($row['total_compras'] ?? $row['total_ventas'] ?? 0);
        }

        // Convertir a array indexado (0-11) con valores en orden
        return array_values($monthlyData);
    }
}
