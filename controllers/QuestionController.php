<?php
require_once './models/QuestionModel.php';
require_once './models/ResponseModel.php';
require_once './helpers/helper.php';

class QuestionController
{
    public function getQuestion()
    {

        $questionModel = new QuestionModel();
        $data = $questionModel->getAll();

        if ($data) {
            echo json_encode([
                'status' => true,
                'message' => 'Preguntas obtenidos con exito',
                'questions' => $data
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'No se pueden obtener las preguntas solicitadas'
            ]);
        }
    }

    public function getAllQuestion()
    {

        $questionModel = new QuestionModel();
        $data = $questionModel->getAll();

        if ($data) {
            echo json_encode([
                'status' => true,
                'message' => 'Datos obtenidos con exito',
                'questions' => $data
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'No se pueden obtener los datos solicitados',
                'questions' => []
            ]);
        }
    }

    // public function getQuestionById($id)
    // {
    //     $questionModel = new QuestionModel();
    //     $currentQuestion = $questionModel->getById($id);
    //     if (!$currentQuestion) {
    //         die(json_encode([
    //             'status' => false,
    //             'message' => 'Pregunta no encontrada'
    //         ]));
    //     } else {
    //         echo json_encode([
    //             'status' => true,
    //             'message' => 'Pregunta encontrada.',
    //             'question' => $currentQuestion
    //         ]);
    //     }
    // }



    public function getQuestionById($id)
    {
        $questionModel = new QuestionModel();
        $currentQuestion = $questionModel->getById($id);
        if (!$currentQuestion) {
            die(json_encode([
                'status' => false,
                'message' => 'Pregunta no encontrada'
            ]));
        } else {
            $responseModel = new ResponseModel();
            $responses = $responseModel->getAllById($currentQuestion->id);

            if (!$responses) {
                echo json_encode([
                    'status' => false,
                    'message' => 'No hay respuestas para esta pregunta.',
                    'question' => $currentQuestion->question_text
                ]);
            } else {
                echo json_encode([
                    'status' => true,
                    'question' => $currentQuestion,
                    'responses' => $responses
                ]);
            }
        }
    }

    public function save()
    {

        $question = [];

        // if (!isset($_POST['ddParentQuestion']) || empty($_POST['ddParentQuestion'])) {
        //     // El campo no fue enviado o está vacío
        //     $question['ddParentQuestion'] = null;
        // } else {
        //     // El campo está definido y tiene un valor
        //     $question['ddParentQuestion'] = $_POST['ddParentQuestion'];
        // }


        // if (isset($_POST['chkDisabledParentQuestion']) && $_POST['chkDisabledParentQuestion'] === '1'){
        //     if (!isset($_POST['ddParentQuestion']) || empty($_POST['ddParentQuestion'])) {
        //         // El campo no fue enviado o está vacío
        //         die(json_encode([
        //             'status' => false,
        //             'message' => 'Las variables parent question no están definidas'
        //         ]));
        //     }else{
        //         // El campo está definido y tiene un valor
        //         $question['ddParentQuestion'] = $_POST['ddParentQuestion'];
        //     }
        // }else{
        //     $question['ddParentQuestion'] = null;
        // }

        if (isset($_POST['chkDisabledParentQuestion']) && $_POST['chkDisabledParentQuestion'] === '1') {
            $question['ddParentQuestion'] = !empty($_POST['ddParentQuestion'])
                ? $_POST['ddParentQuestion']
                : die(json_encode([
                    'status' => false,
                    'message' => 'Las variables parent question no están definidas'
                ]));
        } else {
            $question['ddParentQuestion'] = null;
        }



        $question['chkIsRoot'] = isset($_POST['chkIsRoot']) ? intval($_POST['chkIsRoot']) : 0;


        if (!isset($_POST['txtQuestion']) || empty($_POST['txtQuestion'])) {
            // El campo no fue enviado o está vacío
            die(json_encode([
                'status' => false,
                'message' => 'Las variables no están definidas'
            ]));
        } else {
            // El campo está definido y tiene un valor
            $question['txtQuestion'] = $_POST['txtQuestion'];
        }

        $questionModel = new QuestionModel();
        $response = $questionModel->saveQuestion($question);

        if (isset($response['error']) && !$response['error']) {
            echo json_encode(["status" => false, "message" => $response['message']]);
        } else {
            echo json_encode(["status" => true, "message" => "Respuesta creada con éxito"]);
        }
    }
}
