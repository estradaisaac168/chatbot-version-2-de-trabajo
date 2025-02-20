<?php
require_once './models/DocumentModel.php';
require_once './models/OptionModel.php';
require_once './helpers/TCPDF/tcpdf.php';
require_once './helpers/helper.php';


class DocumentController
{

    public function getDocumentById($id)
    {
        $documnetModel = new DocumentModel();
        $document = $documnetModel->getById($id);

        if (!$document) {
            die(json_encode([
                'status' => false,
                'message' => 'Documento no encontrada'
            ]));
        } else {
            echo json_encode([
                'status' => true,
                'document' => $document
            ]);
        }
    }

    public function save()
    {

        if (!isset($_POST['question'])) {
            die(json_encode([
                'status' => false,
                'message' => 'Las variables no están definidas'
            ]));
        }

        if (empty(trim($_POST['question']))) {
            die(json_encode([
                'status' => false,
                'message' => 'La variables están vacías'
            ]));
        }

        $question = $_POST['question'];

        $questionModel = new QuestionModel();
        $response = $questionModel->saveQuestion($question);

        if (isset($response['error']) && $response['error']) {
            echo json_encode(["status" => false, "message" => $response['message']]);
        } else {
            echo json_encode(["status" => true, "message" => "Pregunta creada con éxito"]);
        }
    }

    public function generatePDF()
    {

        $clave = $_POST['clave'] ?? $_POST['clave']; // Obtener clave desde el formulario
        $responseId = $_POST['responseId'] ?? $_POST['responseId'];


        $name = rand(10000, 99999); //Nombre aleatorio para el documento.

        if (!is_dir('uploads/documents')) {  //Revisa si existe el directorio sino lo crea.
            mkdir('uploads/documents', 0777, true);
        }

        // $pdf = new TCPDF();
        // $pdf->AddPage();
        // $pdf->SetFont('Helvetica', '', 12);
        // $pdf->Cell(0, 10, "Documento generado para la clave: $clave", 0, 1);

        // Datos simulados de la boleta
        $clave = "ABC123";
        $empleado = "Isaac Estrada";
        $empresa = "Call Center - RRHH";
        $salario_base = 1500.00;
        $bonos = 200.00;
        $descuentos = 100.00;
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

        $filePath = dirname(__DIR__) . "/uploads/documents/$name.pdf"; //Ruta absoluta para guardar el pdf

        $pdf->Output($filePath, 'F');  // Guardando el pdf

        // Guardar en la base de datos

        $document = [];

        $document['name'] = $name . ".pdf";
        $document['path'] = $filePath;
        $document['createdAt'] = date('Y-m-d H:i:s');
        $document['responseId'] = $responseId;

        $documentModel = new DocumentModel();
        $response = $documentModel->createDocument($document);

        if (!isset($response['error']) && $response['error']) {
            die(json_encode(["status" => false, "message" => $response['message']]));
        } else {
            die(json_encode(["status" => true, "message" => "Documento creado con éxito", 'id' => $response['id']]));
        }
    }

    public function downloadPDF($documentID)
    {
        if (!isset($documentID) || empty($documentID)) {
            // El campo no fue enviado o está vacío
            die(json_encode([
                'status' => false,
                'message' => 'El id del documento no esta definido'
            ]));
        }

        $documentModel = new DocumentModel();
        $document = $documentModel->getById(intval($documentID));

        if ($document) {

            // $url = stripslashes($document->file_path);

            // echo json_encode([
            //     'status' => true,
            //     'message' => 'Documento encontrado',
            //     "filename" => $document->document_name,
            //     "url" => $url
            // ], JSON_UNESCAPED_SLASHES);

            $filePath = $document->file_path;
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="mi_archivo_real.pdf"');
            readfile($filePath);
            
        } else {

            die(json_encode([
                'status' => false,
                'message' => 'Documento no encontrado'
            ]));
        }
    }
}
