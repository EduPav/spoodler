<?php

$GLOBALS['config']['api'] = [
    'baseUrl' => 'http://spoodler:8080/api',
    'JWTExpiration' => 600 // token validity in seconds
];
$GLOBALS['config']['timeZone'] = 'America/Argentina/Buenos_Aires';
$GLOBALS['config']['db'] = [
    'errors' => [
        'columns' => ['message', 'file', 'description', 'created_at'],
        'requiredColumns' => ['description', 'created_at']
    ],
    'users' => [
        'columns' => ['email', 'password'],
        'requiredColumns' => ['email', 'password']
    ]
];
