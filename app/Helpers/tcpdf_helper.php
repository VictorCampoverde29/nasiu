<?php

function crear_tcpdf(string $titulo = 'Documento PDF', string $orientacion = 'P', string $formato = 'A4'): \TCPDF
{
    $pdf = new \TCPDF($orientacion, PDF_UNIT, $formato, true, 'UTF-8', false);

    $pdf->SetCreator('CodeIgniter TCPDF Helper');
    $pdf->SetAuthor('Tu Nombre o Empresa');
    $pdf->SetTitle($titulo);
    $pdf->SetSubject('Certificados Generados');
    $pdf->SetKeywords('TCPDF, PDF, certificado, CodeIgniter');

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetMargins(30, 15, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    return $pdf;
}
