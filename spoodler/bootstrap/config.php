<?php

$CONFIG = [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'api' => [
        'base_url' => 'http://spoodler:8080/api',
    ],
];
