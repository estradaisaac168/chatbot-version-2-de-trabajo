<?php
require_once './models/MessageModel.php';
require_once './helpers/helper.php';

class MessageController
{
    public function getResponse()
    {

        $messageModel = new MessageModel();
        $data = $messageModel->fetchAllData();

        if ($data) {
            echo json_encode([
                'status' => true, 
                'message' => 'Datos obtenidos con exito',
                'questions' => $data]);
        } else {
            echo json_encode([
                'status' => false, 
                'message' => 'No se pueden obtener los datos solicitados'
            ]);
        }
    }
}
