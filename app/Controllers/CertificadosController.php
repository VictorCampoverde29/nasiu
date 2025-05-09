<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CertificadosModel;
use CodeIgniter\HTTP\ResponseInterface;

class CertificadosController extends BaseController
{
    protected $certificadosModel;

    public function __construct()
    {
        $this->certificadosModel = new CertificadosModel();
    }

    public function imp_cert()
    {
        return view('certificados/imp_cert');
    }
    public function ing_cert()
    {
        return view('certificados/ingcert');
    }

    public function getCertificados()
    {

        $startDate = $this->request->getPost('inicio');
        $endDate = $this->request->getPost('fin');
        $certificados = $this->certificadosModel->getCertificadosbyDate($startDate, $endDate);
        return $this->response->setJSON(['data' => $certificados]);
    }

    public function reporteCertificado()
    {
        require_once(APPPATH . 'Libraries/fpdf/fpdf.php');
    }
    public function generar_certificado($id)
    {
        while (ob_get_level()) {
            ob_end_clean(); // Limpia cualquier buffer de salida previo
        }
        helper('tcpdf');

        // Obtener datos (simulado aquí)
        $cert = $this->certificadosModel->getCertificadoById($id);
        if (!$cert) return redirect()->back()->with('error', 'Certificado no encontrado');

        $pdf = crear_tcpdf('CERTIFICADO N°' . $id);
        $pdf->AddPage();
        $pdf->Ln(5);
        // Agregar imágenes
        $rightImage  = FCPATH . 'public/dist/img/certizq.png';
        $leftImage = FCPATH . 'public/dist/img/certder.png';

        if (file_exists($leftImage)) {
            $pdf->Image($leftImage, 15, 10, 30); // X, Y, Width
        }

        if (file_exists($rightImage)) {
            $pdf->Image($rightImage, 165, 10, 30); // X, Y, Width
        }

        // Encabezado
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(255, 0, 0); // Rojo
        $pdf->Cell(0, 4, 'CARROCERIAS Y MOTOTAXIS', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0); // (opcional) volver al color negro normal para el resto del contenido

        $pdf->Cell(0, 4, 'ZOE COSTA SAC', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'FABRICACION Y ENSAMBLAJE DE VEHICULOS TRIMOTOS', 0, 1, 'C');
        $pdf->Cell(0, 5, 'VENTA DE MOTOCICLETAS, MOTOTAXIS Y SERVICIOS EN GENERAL', 0, 1, 'C');
        $pdf->Cell(0, 5, 'CERTIFICADO DE FABRICACION DE CARROCERIAS Y TRANSFORMACION DE', 0, 1, 'C');
        $pdf->Cell(0, 5, 'MOTO LINEAL A TRIMOTO DE PASAJERO', 0, 1, 'C');
        $pdf->Ln(5);

        // Datos básicos
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 4, 'NUMERO: ' . $cert['expediente'], 0, 1, 'R');
        $pdf->Cell(0, 4, 'FECHA: ' . date('d/m/Y', strtotime($cert['fecha_certificado'])), 0, 1, 'R');
        $pdf->Ln(5);

        // Mensaje descriptivo
        $pdf->SetFont('helvetica', '', 10);
        $mensaje = "La Empresa Zoe Costa SAC, con RUC 20604472858, informa que se cumplió con hacer la modificación de la Moto Lineal a una Unidad TRIMOTO DE PASAJERO, en representación del Gerente General la Srta. MAGDA LIDA CHAMBERGO ASIU, certifica que ha efectuado la Fabricación de la Carrocería y que las exigencias técnicas establecidas en el Reglamento Nacional de Vehículos del D.S. Nº058-2003 MTC, con la normativa vigente en materia de límites máximos permisibles de emisión de contaminantes consideradas en el D.S. Nº 047-2001 MTC, así como todos los requisitos legales conexos vigentes a la fecha. Asimismo, garantiza la Modificación a Nivel Nacional por 180 días y/o 6000 km. de recorrido perdiendo la misma si el usuario realiza un cambio no autorizado por el fabricante y/o cualquier tipo de accidente.";
        $pdf->MultiCell(0, 5, $mensaje, 0, 'J', 0, 1, '', '', true);
        $pdf->Ln(5);

        // Características del vehículo
        $pdf->SetFont('helvetica', 'BU', 11);
        $pdf->Cell(0, 8, 'CARACTERISTICAS DEL VEHICULO:', 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('helvetica', 'B', 10);
        $caracteristicas = [
            'CLASE' => 'VEHICULO AUTOMOTOR MENOR',
            'CATEGORIA' => 'L5',
            'MARCA' => 'ZONGSHEN',
            'MODELO' => $cert['modelo'],
            'VERSION' => $cert['version'],
            'TIPO DE CARROCERIA' => 'TRIMOTO DE PASAJERO',
            'N° DE VIN' => $cert['chasis'],
            'N° DE SERIE' => $cert['chasis'],
            'N° DE MOTOR' => $cert['motor'],
            'COLOR' => $cert['color'],
            'AÑO DE MODELO' => $cert['año_modelo'],
            'AÑO DE FABRICACION' => $cert['año_fabricacion'],
            'N° DE CILINDROS' => '01',
            'CILINDRADA' => $cert['cilindridada'],
            'POTENCIA DE MOTOR' => $cert['potencia'] . ' RPM',
            'COMBUSTIBLE' => 'GASOLINA',
            'FORMULA RODANTE' => '3 X 1',
            'N° DE RUEDAS' => '03',
            'N° DE EJES' => '02',
            'LARGO X ANCHO X ALTURA' => '2840 X 1280 X 1700',
            'PESO NETO' => '240 Kgs',
            'CARGA UTIL' => '210 Kgs',
            'PESO BRUTO VEHICULAR' => '450 Kgs',
            'N° DE ASIENTOS/PASAJEROS' => '03 ASIENTOS / 02 PASAJEROS',
        ];

        foreach ($caracteristicas as $titulo => $valor) {
            $pdf->Cell(80, 5, $titulo, 0, 0, 'L');
            $pdf->Cell(0, 5, ': ' . $valor, 0, 1, 'L');
        }

        $pdf->Ln(22);

        // Pie de página
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 4, 'Calle Teniente Vásquez Mza W-2 Lt 2 Miguel Checa Sullana Piura – Teléfono 978179210', 0, 1, 'C');



        // Salida
        $pdf->Output('CERTIFICADO_' . $cert['expediente'] . '.pdf', 'I');
    }

    public function generar_certificados_lote()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        helper('tcpdf');

        $jsonIds = $this->request->getPost('ids');
        $ids = json_decode($jsonIds, true);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No se seleccionaron certificados válidos.');
        }

        $certificadosDB = $this->certificadosModel
            ->whereIn('idcertificados', $ids)
            ->orderBy('expediente', 'asc')
            ->findAll();

        if (empty($certificadosDB)) {
            return redirect()->back()->with('error', 'No se encontraron certificados.');
        }

        $pdf = crear_tcpdf('CERTIFICADOS SELECCIONADOS');

        $leftImage  = FCPATH . 'public/dist/img/certder.png';
        $rightImage = FCPATH . 'public/dist/img/certizq.png';

        foreach ($certificadosDB as $cert) {
            $pdf->AddPage();
            $pdf->Ln(5);

            // Imágenes
            if (file_exists($leftImage)) {
                $pdf->Image($leftImage, 15, 10, 30);
            }
            if (file_exists($rightImage)) {
                $pdf->Image($rightImage, 165, 10, 30);
            }

            // Encabezado
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(0, 4, 'CARROCERIAS Y MOTOTAXIS', 0, 1, 'C');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(0, 4, 'ZOE COSTA SAC', 0, 1, 'C');

            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'FABRICACION Y ENSAMBLAJE DE VEHICULOS TRIMOTOS', 0, 1, 'C');
            $pdf->Cell(0, 5, 'VENTA DE MOTOCICLETAS, MOTOTAXIS Y SERVICIOS EN GENERAL', 0, 1, 'C');
            $pdf->Cell(0, 5, 'CERTIFICADO DE FABRICACION DE CARROCERIAS Y TRANSFORMACION DE', 0, 1, 'C');
            $pdf->Cell(0, 5, 'MOTO LINEAL A TRIMOTO DE PASAJERO', 0, 1, 'C');
            $pdf->Ln(5);

            // Datos básicos
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(0, 4, 'NUMERO: ' . $cert['expediente'], 0, 1, 'R');
            $pdf->Cell(0, 4, 'FECHA: ' . date('d/m/Y', strtotime($cert['fecha_certificado'])), 0, 1, 'R');
            $pdf->Ln(5);

            // Mensaje
            $mensaje = "La Empresa Zoe Costa SAC, con RUC 20604472858, informa que se cumplió con hacer la modificación de la Moto Lineal a una Unidad TRIMOTO DE PASAJERO, en representación del Gerente General la Srta. MAGDA LIDA CHAMBERGO ASIU, certifica que ha efectuado la Fabricación de la Carrocería y que las exigencias técnicas establecidas en el Reglamento Nacional de Vehículos del D.S. Nº058-2003 MTC, con la normativa vigente en materia de límites máximos permisibles de emisión de contaminantes consideradas en el D.S. Nº 047-2001 MTC, así como todos los requisitos legales conexos vigentes a la fecha. Asimismo, garantiza la Modificación a Nivel Nacional por 180 días y/o 6000 km. de recorrido perdiendo la misma si el usuario realiza un cambio no autorizado por el fabricante y/o cualquier tipo de accidente.";
            $pdf->SetFont('helvetica', '', 10);
            $pdf->MultiCell(0, 5, $mensaje, 0, 'J', 0, 1, '', '', true);
            $pdf->Ln(5);

            // Características
            $pdf->SetFont('helvetica', 'BU', 11);
            $pdf->Cell(0, 8, 'CARACTERISTICAS DEL VEHICULO:', 0, 1, 'L');
            $pdf->Ln(2);

            $pdf->SetFont('helvetica', 'B', 10);

            $caracteristicas = [
                'CLASE' => 'VEHICULO AUTOMOTOR MENOR',
                'CATEGORIA' => 'L5',
                'MARCA' => 'ZONGSHEN',
                'MODELO' => $cert['modelo'],
                'VERSION' => $cert['version'],
                'TIPO DE CARROCERIA' => 'TRIMOTO DE PASAJERO',
                'N° DE VIN' => $cert['chasis'],
                'N° DE SERIE' => $cert['chasis'],
                'N° DE MOTOR' => $cert['motor'],
                'COLOR' => $cert['color'],
                'AÑO DE MODELO' => $cert['año_modelo'],
                'AÑO DE FABRICACION' => $cert['año_fabricacion'],
                'N° DE CILINDROS' => '01',
                'CILINDRADA' => $cert['cilindridada'],
                'POTENCIA DE MOTOR' => $cert['potencia'] . ' RPM',
                'COMBUSTIBLE' => 'GASOLINA',
                'FORMULA RODANTE' => '3 X 1',
                'N° DE RUEDAS' => '03',
                'N° DE EJES' => '02',
                'LARGO X ANCHO X ALTURA' => '2840 X 1280 X 1700',
                'PESO NETO' => '240 Kgs',
                'CARGA UTIL' => '210 Kgs',
                'PESO BRUTO VEHICULAR' => '450 Kgs',
                'N° DE ASIENTOS/PASAJEROS' => '03 ASIENTOS / 02 PASAJEROS',
            ];

            foreach ($caracteristicas as $titulo => $valor) {
                $pdf->Cell(80, 5, $titulo, 0, 0, 'L');
                $pdf->Cell(0, 5, ': ' . $valor, 0, 1, 'L');
            }

            $pdf->Ln(22);

            // Pie
            $pdf->SetFont('helvetica', '', 9);
            $pdf->Cell(0, 4, 'Calle Teniente Vásquez Mza W-2 Lt 2 Miguel Checa Sullana Piura – Teléfono 978179210', 0, 1, 'C');
        }

        // Salida final
        $pdf->Output('CERTIFICADOS_SELECCIONADOS.pdf', 'I');
    }

    public function guardar_lote()
    {
        try {
            helper('text');

            $certificados = $this->request->getPost('certificados');
            $idSerie = session()->get('idseries_correlativos'); // o captúralo desde el frontend si varía

            // Iniciar XMLWriter
            $xml = new \XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement("Certificados");

            // Serie (cabecera para el SP)
            $xml->writeElement("Serie", $idSerie);

            // Recorrer cada certificado
            foreach ($certificados as $cert) {
                $xml->startElement("Fila");

                $xml->writeElement("Fecha", $cert['fecha']);
                $xml->writeElement("Modelo", $cert['modelo']);
                $xml->writeElement("Cilindrada", $cert['cilindrada']);
                $xml->writeElement("Potencia", $cert['potencia']);
                $xml->writeElement("Color", $cert['color']);
                $xml->writeElement("A_modelo", $cert['anio_modelo']);
                $xml->writeElement("A_fabricacion", $cert['anio_fabricacion']);
                $xml->writeElement("Version", $cert['version']);
                $xml->writeElement("Motor", $cert['motor']);
                $xml->writeElement("Chasis", $cert['chasis']);
                $xml->writeElement("CodSer", $idSerie); // necesario para actualizar correlativo

                $xml->endElement(); // Fila
            }

            $xml->endElement(); // Certificados
            $xml->endDocument();
            $xmlString = $xml->outputMemory();

            // Ejecutar el SP con XML
            $db = \Config\Database::connect();
            $query = $db->query("CALL AGREGAR_CERTIFICADOS_EN_BLOQUE(?, @mensaje)", [$xmlString]);

            // Recuperar el mensaje del SP
            $mensaje = $db->query("SELECT @mensaje AS mensaje")->getRow()->mensaje;

            echo $mensaje;
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
