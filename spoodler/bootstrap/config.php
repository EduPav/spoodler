<?php

$GLOBALS['config']['api']['JWTExpiration'] = 600; // token validity in seconds
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

$GLOBALS['config']['advice']['enabled'] = false;
$GLOBALS['config']['advice']['model'] = "gpt-4o-mini";
$GLOBALS['config']['advice']['charLimit'] = 500;
