<?php
require_once './models/ResponseModel.php';
require_once './models/OptionModel.php';
require_once './helpers/TCPDF/tcpdf.php';
require_once './helpers/helper.php';


class ResponseController
{

    public function getResponseById($id)
    {

        if(!validateId($id)){
            
            echo json_encode([
                'status' => false,
                'message' => 'Parametro no valido'
            ]);

            die;

        }else{
            $responseModel = new ResponseModel();
            $response = $responseModel->getById($id);

            if (!$response) {
                die(json_encode([
                    'status' => false,
                    'message' => 'Respuesta no encontrada'
                ]));
            } else {
                echo json_encode([
                    'status' => true,
                    'response' => $response
                ]);
            }
        }
    }
}
