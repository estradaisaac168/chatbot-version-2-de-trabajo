<?php
function routeRequest($uri, $method)
{
    $path = parse_url($uri, PHP_URL_PATH);

    $segments = explode('/', trim($path, '/'));


    // Aquí se agregarán las rutas dinámicas
    if (count($segments) >= 1) {
        // Llamar al controlador adecuado según la ruta
        switch ($segments[0]) {
            case 'question':
                require_once './controllers/QuestionController.php';
                $controller = new QuestionController();

                if ($method === 'GET') {
                    if (count($segments) === 1) $controller->getQuestion();
                    if (count($segments) === 2 && $segments[0] == 'question') $controller->getQuestionById($segments[1]);
                } else if ($method === 'POST' && count($segments) === 2 && $segments[1] == 'save') {
                    $controller->save();
                } else {
                    echo json_encode(["error" => "Parámetro inválido"]);
                }

                break;


            case 'type':
                require_once './controllers/TypeController.php';
                $controller = new TypeController();

                if ($method === 'GET') {
                    // Obtener todos los datos del chatbot
                    $controller->getAllTypes();
                }
                break;

            case 'option':
                require_once './controllers/OptionController.php';
                $controller = new OptionController();

                if ($method === 'GET') {

                    if (count($segments) === 1 && $segments[0] === 'option') {
                        $controller->getAllOptions();
                    } elseif (count($segments) === 2 && $segments[0] === 'option') {
                        $controller->getOptionById($segments[1]);
                    }
                }

                // if ($method === 'GET' && count($segments) > 1 && $segments[1] == 'getOptionsNotNull') {
                //     // Obtener todos los datos del chatbot
                //     $controller->getAllOptionsNotNull();
                // }

                // if ($method === 'GET' && count($segments) > 1 && $segments[1] == 'getOptionsIsNull') {
                //     $controller->getAllOptionsIsNull();
                // }

                // if ($method === 'GET' && count($segments) > 2 && is_numeric($segments[2])) {
                //     $controller->getResponseById($segments[2]);
                // }

                if ($method === 'POST') {
                    // $controller->save();
                }
                break;


            case 'document':
                require_once './controllers/DocumentController.php';
                $controller = new DocumentController();

                if ($method === 'GET') {
                    // if (count($segments) === 1) $controller->getAllDocument();
                    if (count($segments) === 3 && $segments[0] == 'document' && $segments[1] == 'download') $controller->downloadPDF($segments[2]);
                    if (count($segments) === 3 && $segments[0] == 'document' && $segments[1] == 'send') $controller->sendDocument($segments[2]);
                } else if ($method === 'POST' && count($segments) === 2 && $segments[1] == 'generate') {
                    $controller->generatePDF();
                } else {
                    echo json_encode(["error" => "Parámetro inválido"]);
                }
                break;

            case 'response':

                require_once './controllers/ResponseController.php';
                $controller = new ResponseController();


                if ($method === 'GET') {
                    // if (count($segments) === 1) $controller->getQuestion();
                    if (count($segments) === 2 && $segments[0] == 'response') $controller->getResponseById($segments[1]);
                } else if ($method === 'POST' && count($segments) === 2 && $segments[1] == 'save') {
                    // $controller->save();
                } else {
                    echo json_encode(["error" => "Parámetro inválido"]);
                }

                // if ($method === 'POST') {
                //     $controller->save();
                // }
                break;
                // Puedes agregar más rutas aquí según lo necesites


            default:
                // Ruta no encontrada
                echo json_encode(["error" => "Ruta no válida"]);
                break;
        }
    }
}
