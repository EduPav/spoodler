<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Load Composer autoloader
require __DIR__ . '/config.php'; // Set global constants or configurations

use Dotenv\Dotenv;

// Load environment variables from .env file
if (file_exists(__DIR__ . '/../.env.testing')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../', '.env.testing');
    $dotenv->load();
}
