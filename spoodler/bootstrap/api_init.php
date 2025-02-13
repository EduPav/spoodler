<?php

require_once __DIR__ . '/../bootstrap/init.php';

use classes\api\Router;

$app = Flight::app();

$router = new Router();
$router->buildRoutes($app);

$app->map('sendSuccess', function (array $data, int $statusCode = 200) {
    Flight::json(["data" => $data, "message" => ""], $statusCode);
});

$app->map('sendError', function (string $message, int $statusCode) {
    Flight::jsonHalt(["data" => [], "message" => $message], $statusCode);
});

// CORS
header("Access-Control-Allow-Origin: *"); // Allows any domain (you can specify a specific one)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allowed request types
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

