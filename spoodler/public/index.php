<?php
// RESTful API
require_once __DIR__ . '/../bootstrap/init.php';

use classes\api\Api;

$app = Flight::app();
// Map custom output methods
$app->map('sendSuccess', function (array $data, int $statusCode = 200) {
    Flight::json(["data" => $data, "message" => ""], $statusCode);
});
$app->map('sendError', function (string $message, int $statusCode) {
    Flight::jsonHalt(["data" => [], "message" => $message], $statusCode);
});

$api = new Api($app, $logger);
$api->run();