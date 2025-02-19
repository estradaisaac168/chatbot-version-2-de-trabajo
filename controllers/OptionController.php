<?php
require_once './models/OptionModel.php';
require_once './models/DocumentModel.php';
require_once './helpers/helper.php';

class OptionController
{

    public function getAllOptions()
    {

        $optionModel = new OptionModel();
        $options = $optionModel->getAll();

        if (!$options) {
            echo json_encode([
                'status' => false,
                'message' => 'No se pueden las opciones solicitadas'
            ]);
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'No hay opciones disponibles',
                'options' => $options
            ]);
        }
    }


    public function getOptionById($id)
    {
        $optionModel = new OptionModel();
        $options = $optionModel->getById($id);
        if (!$options) {
            die(json_encode([
                'status' => false,
                'message' => 'Opciones no encontradas'
            ]));
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'Opciones encontradas.',
                'question' => $options
            ]);
        }
    }


    // public function getAllOptionsNotNull()
    // {

    //     $optionModel = new OptionModel();
    //     $data = $optionModel->getAllNotNull();

    //     if ($data) {
    //         echo json_encode([
    //             'status' => true,
    //             'message' => 'Datos obtenidos con exito',
    //             'options' => $data
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'No se pueden obtener los datos solicitados'
    //         ]);
    //     }
    // }

    // public function getAllOptionsIsNull()
    // {

    //     $optionModel = new OptionModel();
    //     $data = $optionModel->getAllIsNull();

    //     if ($data) {
    //         echo json_encode([
    //             'status' => true,
    //             'message' => 'Datos obtenidos con exito',
    //             'options' => $data
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'No se pueden obtener los datos solicitados'
    //         ]);
    //     }
    // }



    // public function save()
    // {

    //     // die(json_encode([
    //     //     'status' => false,
    //     //     'message' => $_POST
    //     // ]));

    //     $option = [];
    //     $document = [];

    //     if (!isset($_POST['ddType']) || empty($_POST['ddType'])) {
    //         // El campo no fue enviado o está vacío
    //         die(json_encode([
    //             'status' => false,
    //             'message' => 'Las variables Type no están definidas'
    //         ]));
    //     } else {
    //         // El campo está definido y tiene un valor
    //         $option['ddType'] = $_POST['ddType'];
    //     }

    //     if (!isset($_POST['txtOption']) || empty($_POST['txtOption'])) {
    //         // El campo no fue enviado o está vacío
    //         die(json_encode([
    //             'status' => false,
    //             'message' => 'Las variables option no están definidas'
    //         ]));
    //     } else {
    //         // El campo está definido y tiene un valor
    //         $option['txtOption'] = $_POST['txtOption'];
    //     }

    //     if (!isset($_POST['ddQuestion']) || empty($_POST['ddQuestion'])) {
    //         // El campo no fue enviado o está vacío
    //         die(json_encode([
    //             'status' => false,
    //             'message' => 'Las variables question no están definidas'
    //         ]));
    //     } else {
    //         // El campo está definido y tiene un valor
    //         $option['ddQuestion'] = $_POST['ddQuestion'];
    //     }

    //     if (isset($_POST['chkDisabledQuestionNext']) && $_POST['chkDisabledQuestionNext'] === 'true'){
    //         if (!isset($_POST['ddQuestionNext']) || empty($_POST['ddQuestionNext'])) {
    //             // El campo no fue enviado o está vacío
    //             die(json_encode([
    //                 'status' => false,
    //                 'message' => 'Las variables next question no están definidas'
    //             ]));
    //         }else{
    //             // El campo está definido y tiene un valor
    //             $option['ddQuestionNext'] = $_POST['ddQuestionNext'];
    //         }
    //     }else{
    //         $option['ddQuestionNext'] = null;
    //     }


    //     if (isset($_POST['ddType']) && $_POST['ddType'] == 2) {

    //         if (!isset($_POST['txtOptionDocumentName']) || empty($_POST['txtOptionDocumentName'])) {
    //             // El campo no fue enviado o está vacío
    //             die(json_encode([
    //                 'status' => false,
    //                 'message' => 'Las variables doc name no están definidas'
    //             ]));
    //         } else {
    //             // El campo está definido y tiene un valor
    //             $document['txtOptionDocumentName'] = $_POST['txtOptionDocumentName'];
    //         }

    //         if (!isset($_POST['txtFileOptionDocument']) || empty($_POST['txtFileOptionDocument'])) {
    //             // El campo no fue enviado o está vacío
    //             die(json_encode([
    //                 'status' => false,
    //                 'message' => 'Las variables doc file no están definidas'
    //             ]));
    //         } else {
    //             // El campo está definido y tiene un valor
    //             $document['txtFileOptionDocument'] = $_POST['txtFileOptionDocument'];
    //         }
    //     }


    //     $optionModel = new OptionModel();
    //     $response = $optionModel->createOption($option);

    //     if (!isset($response['error']) && $response['error']) {
    //         echo json_encode(["status" => false, "message" => $response['message']]);
    //     } else {

    //         $document['lastInsertId'] = $response['id'];
    //         $document['createdAt'] = date('Y-m-d H:i:s');

    //         if (isset($_POST['ddType']) && $_POST['ddType'] == 2) {

    //             $documentModel = new DocumentModel();
    //             $response = $documentModel->createDocument($document);

    //             if (!isset($response['error']) && $response['error']) {
    //                 echo json_encode(["status" => false, "message" => $response['message']]);
    //             } else {
    //                 die(json_encode(["status" => true, "message" => "Opcion y documento creados con éxito"]));
    //             }
    //         }
    //         echo json_encode(["status" => true, "message" => "Opcion creada con éxito"]);
    //     }

    // }
}
