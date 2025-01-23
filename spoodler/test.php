<?php

require_once __DIR__ . '/bootstrap/init.php';

use classes\db\ErrorLogTable;

echo '<pre>';
// print_r($_ENV);
// print_r($CONFIG);

$errorTable = new ErrorLogTable();
echo "All errors";
echo json_encode($errorTable->getAll());
echo "Error with id=2 \n";
echo json_encode($errorTable->getById(2));

echo '</pre>';
