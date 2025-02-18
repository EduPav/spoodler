<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Load Composer autoloader
require __DIR__ . '/config.php'; // Set global constants or configurations

use Dotenv\Dotenv;
use classes\logger\LoggerBuilder;

// Load environment variables from .env file
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// ERROR HANDLING
// Disable error display on browser for prod.
ini_set('display_errors', $_ENV['APP_ENV'] === 'development' ? '1' : '0');
// Enable error logging
ini_set('log_errors', 1);
error_reporting(E_ALL);
$logger = (new LoggerBuilder())->getLogger();

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
