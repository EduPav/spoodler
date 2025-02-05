<?php

require_once __DIR__ . '/../bootstrap/init.php';

use classes\api\Header;
use classes\api\legacy\control\LegacyController;
use classes\api\legacy\render\Json;
use classes\api\legacy\render\Text;
use classes\api\legacy\Request;
use classes\db\ErrorLogTable;
use classes\report\LegacyHandler;
use classes\utils\UserInputHandler;

$logger->info("Request to v1 HTTP API received");
$asText = isset($_GET['asText']) && $_GET['asText'] == 'true';
$renderer = $asText ? new Text(new Header()) : $renderer = new Json(new Header());
$handler = new LegacyHandler(new ErrorLogTable(), new UserInputHandler());
$controller = new LegacyController($logger, $renderer, $handler, 200);
$request = new Request($_GET);

echo $controller->handle($request);
