<?php

require_once __DIR__ . '/../bootstrap/init.php';

use classes\api\exception\server\InternalServerErrorException;
use classes\db\ErrorLogTable;

echo '<pre>';
// To call configs and envs
// print_r($_ENV);
// print_r($GLOBALS['config']);

// To get values from errortable
$errorTable = new ErrorLogTable();
echo "All errors";
echo json_encode($errorTable->getAll());
// echo "Error with id=2 \n";
// echo json_encode($errorTable->getById(2));

//LOGGER
// $logger->info("This message has no context to log");
// $logger->info("This message has context. Cool right?", ['file' => 'test.php']);
// $logger->error("This is an example error logging for db", ["file" => "test.php", "shortMessage" => "short error message."]);
echo '</pre>';
// throw new InternalServerErrorException('A test of system reaction');
