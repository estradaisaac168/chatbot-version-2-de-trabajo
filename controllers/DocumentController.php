<?php
require_once './models/DocumentModel.php';
require_once './models/OptionModel.php';
require_once './helpers/TCPDF/tcpdf.php';
require_once './helpers/helper.php';
require './helpers/sendEmail.php';
require_once './config/config.php';



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

        // die(json_encode([
        //     'status' => false,
        //     'message' => intval($_POST['type'])
        // ]));

        

        if (!isset($_POST['type'])) {
            die(json_encode([
                'status' => false,
                'message' => 'Las variable type no está definida'
            ]));
        }

        if (empty(trim($_POST['type']))) {
            die(json_encode([
                'status' => false,
                'message' => 'La variable type está vacía'
            ]));
        }

        // $type = $_POST['type'] ?? $_POST['type']; // Obtener clave desde el formulario
        $responseId = $_POST['responseId'] ?? $_POST['responseId'];
        $filePath = '';


        switch (intval($_POST['type'])) {
            case 1:
                $nameFile = 'constancia_laboral_' . rand(10000, 99999);
                $filePath = generarConstanciaSalarial($nameFile, "Isaac", "RRHH", 1000, 30, 1500, date("d/m/Y") );
                break;

            case 2:
                $nameFile = 'boleta_pago_' . rand(10000, 99999);
                $filePath = generarBoletaPago($nameFile);
                break;

            default:
            // $nameFile = 'constancia_laboral_' . rand(10000, 99999);
            // $filePath = generarConstanciaLaboral($nameFile , "Isaac", "RRHH", "Ingeniero", date("d/m/Y"));

                break;
        }


        // $name = rand(10000, 99999); //Nombre aleatorio para el documento.

        if (!is_dir('uploads/documents')) {  //Revisa si existe el directorio sino lo crea.
            mkdir('uploads/documents', 0777, true);
        }

        // Guardar en la base de datos

        $document = [];

        $document['name'] = $nameFile . ".pdf";
        $document['path'] = $filePath;
        $document['createdAt'] = date('Y-m-d H:i:s');
        $document['responseId'] = $responseId;

        $documentModel = new DocumentModel();
        $response = $documentModel->createDocument($document);

        if (!isset($response['error']) && $response['error']) {
            die(json_encode(["status" => false, "message" => $response['message']]));
        } else {
            die(json_encode(["status" => true, "message" => "Documento creado con éxito", "id" => $response['id']])); //Me retorna el id del ultimo creado
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


    public function sendDocument($documentID)
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

            $recipient = 'odiliorosales00@gmail.com';
            $subject = $document->document_name;
            $message = '<h1>Hola</h1><p>Se ha adjuntado tu documento.</p>';

            if (sendEmail($recipient, $subject, $message, $document->file_path, $document->document_name)) {

                echo json_encode([
                    'status' => true,
                    'message' => "Se mando el correo con exito revisa tu bandeja de entrada o carpeta de spam"
                ]);
                die;
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => "No se pudo mandar el correo"
                ]);
                die;
            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => "El documento no existe"
            ]);
            die;
        }





        // echo sendEmail($recipient, $subject, $message);

        // $documentModel = new DocumentModel();
        // $document = $documentModel->getById(intval($documentID));

        // if ($document) {

        //     // $url = stripslashes($document->file_path);

        //     // echo json_encode([
        //     //     'status' => true,
        //     //     'message' => 'Documento encontrado',
        //     //     "filename" => $document->document_name,
        //     //     "url" => $url
        //     // ], JSON_UNESCAPED_SLASHES);

        //     $filePath = $document->file_path;
        //     header('Content-Type: application/pdf');
        //     header('Content-Disposition: attachment; filename="mi_archivo_real.pdf"');
        //     readfile($filePath);
        // } else {

        //     die(json_encode([
        //         'status' => false,
        //         'message' => 'Documento no encontrado'
        //     ]));
        // }
    }
}
