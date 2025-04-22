<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    private $token;

    public function __construct()
    {
        date_default_timezone_set("America/Lima");
        $this->token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzNjEiLCJuYW1lIjoiVmljdG9yIEFuZHJlZSBDYW1wb3ZlcmRlIFZlZ2EiLCJlbWFpbCI6ImFuZHJlZWNhbXBvdmVyZGUuYWNAZ21haWwuY29tIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiY29uc3VsdG9yIn0.q7r1NsoO9aqubwt9rTWB6yYEXvvcAO6Wp5Pny1jX-d0';
    }

    public function buscarDni()
    {
        $dni = $this->request->getPost('dni');

        // Validar que el DNI no esté vacío
        if (empty($dni)) {
            return $this->response->setJSON(['error' => 'DNI es requerido'])->setStatusCode(400);
        }

        // Iniciar llamada a API
        $curl = curl_init();

        // Configurar CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.factiliza.com/pe/v1/dni/info/' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $persona = json_decode($response);

        if ($persona->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($persona->data);
        }
    }

    public function buscarRUC()
    {
        $ruc = $this->request->getPost('ruc');
        log_message('debug', 'El ruc ingresado es:' . $ruc);
        // Validar que el DNI no esté vacío
        if (empty($ruc)) {
            return $this->response->setJSON(['error' => 'RUC es requerido'])->setStatusCode(400);
        }

        // Iniciar llamada a API
        $curl = curl_init();

        // Configurar CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.factiliza.com/pe/v1/ruc/info/' . $ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $empresa = json_decode($response);
        log_message('info', 'Respuesta de la API de tipo de cambio: ' . json_encode($empresa));

        if ($empresa->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($empresa->data);
        }
    }
    public function tipoCambioDia()
    {
        // Verificar si ya hay un tipo de cambio guardado en la sesión
        if (!session()->has('tcactual')) {
            $fecha = date("Y-m-d");

            // Iniciar llamada a la API
            $curl = curl_init();

            // Configurar CURL
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.factiliza.com/pe/v1/tipocambio/info/dia?fecha=' . $fecha,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->token
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $tipoCambioSunat = json_decode($response);

            // Log para depuración
            //log_message('info', 'Respuesta de la API de tipo de cambio: ' . json_encode($tipoCambioSunat));

            // Comprobar si la respuesta contiene el tipo de cambio
            if (isset($tipoCambioSunat->data->venta)) {
                // Guardar el tipo de cambio en la sesión
                session()->set('tcactual', $tipoCambioSunat->data->venta);
                return $this->response->setJSON(['tipoCambio' => $tipoCambioSunat->data->venta]);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo obtener el tipo de cambio'])->setStatusCode(500);
            }
        } else {
            // Retornar el tipo de cambio almacenado en sesión
            return $this->response->setJSON(['tipoCambio' => session()->get('tcactual')]);
        }
    }


    public function buscarDocumento()
    {

        $ruc = $this->request->getPost('ruc');
        $tipo = $this->request->getPost('tipo');
        $documento = $this->request->getPost('doc');
        //log_message('debug','El ruc ingresado es:'.$documento);
        // Validar que el DNI no esté vacío
        if (empty($ruc)) {
            return $this->response->setJSON(['error' => 'RUC es requerido'])->setStatusCode(400);
        }

        // Iniciar llamada a API
        $curl = curl_init();

        // Configurar CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.factiliza.com/pe/v1/sunat/' . $tipo . '/' . $ruc . '-' . $documento,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $datosdoc = json_decode($response);
        log_message('info', 'Tipo:' . $tipo . 'Respuesta de consulta CPE: ' . json_encode($datosdoc));

        if ($datosdoc->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($datosdoc->data);
        }
    }

    public function obtener_xml()
    {
        $ruc = $this->request->getGet('ruc');
        $tipo = $this->request->getGet('tipo');
        $documento = $this->request->getGet('doc');

        if (empty($ruc)) {
            return $this->response->setJSON(['error' => 'RUC es requerido'])->setStatusCode(400);
        }

        // Iniciar llamada a API
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.factiliza.com/v1/sunat/xml/' . $ruc . '-' . $tipo . '-' . $documento,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $datosdoc = json_decode($response);
        if (!isset($datosdoc->status) || $datosdoc->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        }

        // Obtener la cadena Base64
        $base64XML = $datosdoc->data;
        $decodedData = base64_decode($base64XML, true);

        if ($decodedData === false) {
            return $this->response->setJSON(['error' => 'Error al decodificar Base64'])->setStatusCode(400);
        }

        if (substr($decodedData, 0, 2) === "PK") { // Si es un ZIP
            $zipPath = WRITEPATH . "temp" . DIRECTORY_SEPARATOR . "archivo.zip";
            $extractPath = WRITEPATH . "temp" . DIRECTORY_SEPARATOR . "xml_extract_" . uniqid();

            // Crear carpeta temp si no existe
            if (!is_dir(WRITEPATH . "temp")) {
                mkdir(WRITEPATH . "temp", 0777, true);
            }

            file_put_contents($zipPath, $decodedData);

            // Crear carpeta de extracción si no existe
            if (!is_dir($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip = new \ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                // 🔥 Eliminar el archivo ZIP después de descomprimirlo
                unlink($zipPath);

                // Buscar el archivo XML extraído
                $xmlFile = null;
                foreach (scandir($extractPath) as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === "xml") {
                        $xmlFile = $extractPath . DIRECTORY_SEPARATOR . $file;
                        break;
                    }
                }

                if (!$xmlFile) {
                    // Eliminar carpeta si no se encontró XML
                    $this->eliminarCarpeta($extractPath);
                    return $this->response->setJSON(['error' => 'No se encontró un XML en el ZIP'])->setStatusCode(400);
                }

                // Leer el XML
                $xmlContent = file_get_contents($xmlFile);
                $xml = simplexml_load_string($xmlContent);
                $jsonData = json_encode($xml, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


                // 🔥 Eliminar la carpeta después de leer el XML
                $this->eliminarCarpeta($extractPath);

                return $this->response->setJSON(['xml' => $xml->asXML()]);
            }

            return $this->response->setJSON(['error' => 'No es un ZIP válido'])->setStatusCode(400);
        }

        return $this->response->setJSON(['error' => 'Formato no reconocido'])->setStatusCode(400);
    }

    /**
     * Función para eliminar una carpeta y su contenido
     */
    private function eliminarCarpeta($carpeta)
    {
        if (!is_dir($carpeta)) {
            return;
        }

        $archivos = array_diff(scandir($carpeta), ['.', '..']);

        foreach ($archivos as $archivo) {
            $rutaArchivo = $carpeta . DIRECTORY_SEPARATOR . $archivo;
            if (is_dir($rutaArchivo)) {
                $this->eliminarCarpeta($rutaArchivo);
            } else {
                unlink($rutaArchivo);
            }
        }

        rmdir($carpeta); // Elimina la carpeta después de borrar su contenido
    }

    public function ConsultarPLaca()
    {
        $placa = $this->request->getPost('placa');

        // Validar que la placa no esté vacía
        if (empty($placa)) {
            return $this->response->setJSON(['error' => 'Placa es requerida'])->setStatusCode(400);
        }

        // Iniciar llamada a API
        $curl = curl_init();

        // Configurar CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.factiliza.com/pe/v1/placa/info/' . $placa,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $vehiculo = json_decode($response);

        if ($vehiculo->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($vehiculo->data);
        }
    }

    
}
