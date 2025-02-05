<?php
// RESTful API
require_once __DIR__ . '/../bootstrap/api_init.php';

use classes\api\Api;

$api = new Api($app, $logger);
$api->run();