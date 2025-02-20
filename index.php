<?php

header("Access-Control-Allow-Origin: https://5502-idx-chatbot-1739282265787.cluster-joak5ukfbnbyqspg4tewa33d24.cloudworkstations.dev/");

// // Permitir credenciales
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json');

// Manejar solicitudes OPTIONS (Preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


// Aquí tu código PHP para manejar las solicitudes
//echo json_encode(["message" => "CORS configurado correctamente"]);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Incluir rutas
require_once './routes/router.php';


// Procesar la solicitud
routeRequest($requestUri, $requestMethod);
