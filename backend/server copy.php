<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') 
{
    http_response_code(200);
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI']);
$query = $uri['query'];
parse_str($query,$query_array);
$module = $query_array['module'];

if (!$module) 
{
    http_response_code(400);
    echo json_encode(["error" => "Módulo no especificado"]);
    exit();
}

$routeFile = __DIR__ . "/routes/{$module}Routes.php";

if (file_exists($routeFile)) 
{
    require_once($routeFile);
} 
else 
{
    http_response_code(404);
    echo json_encode(["error" => "Ruta para el módulo '{$module}' no encontrada"]);
    exit();
}
