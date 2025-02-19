<?php
require_once './models/TypeModel.php';
require_once './helpers/helper.php';

class TypeController
{
    public function getAllTypes()
    {

        $typeModel = new TypeModel();
        $data = $typeModel->fetchAllData();

        if ($data) {
            echo json_encode([
                'status' => true, 
                'message' => 'Datos obtenidos con exito',
                'types' => $data]);
        } else {
            echo json_encode([
                'status' => false, 
                'message' => 'No se pueden obtener los datos solicitados',
                'types' => []
            ]);
        }
    }
}
