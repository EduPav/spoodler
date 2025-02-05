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
