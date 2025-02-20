<?php
function sendResponse($statusCode, $data)
{
    http_response_code($statusCode);
    echo json_encode($data);
}

function validateId($id)
{
    if (!isset($id) || trim($id) == '') {
        return false;
    } else {
        $id = intval($id);

        if ($id <= 0) {
            return false;
        }
    }

    return true;
}


function generarBoletaPago($nombreArchivo, $clave = "ABC123", $empleado = "Isaac Estrada", $empresa = "Call Center - RRHH", $salario_base = 1500.00, $bonos = 200.00, $descuentos = 100.00)
{
    // Datos simulados de la boleta
    $total_pago = $salario_base + $bonos - $descuentos;
    $fecha_emision = date("d/m/Y");

    // Crear PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 12);

    // Título
    $pdf->Cell(0, 10, "BOLETA DE PAGO", 0, 1, 'C');
    $pdf->Ln(5); // Salto de línea

    // Información del empleado
    $pdf->Cell(0, 10, "Empresa: $empresa", 0, 1);
    $pdf->Cell(0, 10, "Empleado: $empleado", 0, 1);
    $pdf->Cell(0, 10, "Clave: $clave", 0, 1);
    $pdf->Cell(0, 10, "Fecha de emisión: $fecha_emision", 0, 1);
    $pdf->Ln(5);

    // Tabla de pagos
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(80, 10, "Concepto", 1);
    $pdf->Cell(40, 10, "Monto", 1, 1);

    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(80, 10, "Salario Base", 1);
    $pdf->Cell(40, 10, "$" . number_format($salario_base, 2), 1, 1);

    $pdf->Cell(80, 10, "Bonos", 1);
    $pdf->Cell(40, 10, "$" . number_format($bonos, 2), 1, 1);

    $pdf->Cell(80, 10, "Descuentos", 1);
    $pdf->Cell(40, 10, "-$" . number_format($descuentos, 2), 1, 1);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(80, 10, "Total a Pagar", 1);
    $pdf->Cell(40, 10, "$" . number_format($total_pago, 2), 1, 1);

    // Definir la ruta del archivo
    $filePath = UPLOAD_DIR . $nombreArchivo . '.pdf'; // Puedes usar un nombre de archivo dinámico

    // Guardar el PDF en el servidor
    $pdf->Output($filePath, 'F');  // Guardando el pdf

    return $filePath;  // Regresar la ruta del archivo generado (opcional)
}



function generarConstanciaLaboral($nombreArchivo, $empleado, $empresa, $cargo, $fecha_inicio, $fecha_emision = null)
{
    if (!$fecha_emision) {
        $fecha_emision = date("d/m/Y"); // Si no se pasa la fecha de emisión, se usa la actual.
    }

    // Crear PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 12);

    // Título
    $pdf->Cell(0, 10, "CONSTANCIA DE TRABAJO", 0, 1, 'C');
    $pdf->Ln(10); // Salto de línea

    // Texto de la constancia
    $pdf->MultiCell(0, 10, "Por medio de la presente, se hace constar que el Sr(a). $empleado, "
        . "con documento de identidad XXXXXXXX, labora en nuestra empresa $empresa "
        . "desempeñando el cargo de $cargo desde el $fecha_inicio.\n\n"
        . "La presente constancia se emite a solicitud del interesado(a) para los fines que considere convenientes.\n\n"
        . "Fecha de emisión: $fecha_emision", 0, 'L');

    // Definir la ruta del archivo
    $filePath = UPLOAD_DIR . $nombreArchivo . '.pdf'; // Ruta donde se guardará el PDF

    // Guardar el PDF en el servidor
    $pdf->Output($filePath, 'F');  // Guardando el pdf

    return $filePath;  // Regresar la ruta del archivo generado
}



function generarConstanciaSalarial($nombreArchivo, $empleado, $empresa, $salario_base, $bonos, $descuentos, $fecha_emision = null) {
    if (!$fecha_emision) {
        $fecha_emision = date("d/m/Y"); // Si no se pasa la fecha de emisión, se usa la actual.
    }

    // Calcular el total del salario
    $total_pago = $salario_base + $bonos - $descuentos;

    // Crear PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 12);

    // Título
    $pdf->Cell(0, 10, "CONSTANCIA SALARIAL", 0, 1, 'C');
    $pdf->Ln(10); // Salto de línea

    // Texto de la constancia
    $pdf->MultiCell(0, 10, "Por medio de la presente, se hace constar que el Sr(a). $empleado, "
        . "con documento de identidad XXXXXXXX, labora en nuestra empresa $empresa "
        . "y recibe un salario mensual de la siguiente manera:\n\n"
        . "Salario Base: $" . number_format($salario_base, 2) . "\n"
        . "Bonos: $" . number_format($bonos, 2) . "\n"
        . "Descuentos: -$" . number_format($descuentos, 2) . "\n\n"
        . "Total Salarial: $" . number_format($total_pago, 2) . "\n\n"
        . "Fecha de emisión: $fecha_emision", 0, 'L');

    // Definir la ruta del archivo
    $filePath = UPLOAD_DIR . $nombreArchivo . '.pdf'; // Ruta donde se guardará el PDF

    // Guardar el PDF en el servidor
    $pdf->Output($filePath, 'F');  // Guardando el pdf

    return $filePath;  // Regresar la ruta del archivo generado
}