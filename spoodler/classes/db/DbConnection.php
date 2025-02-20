<?php

namespace classes\db;

use PDO;
use PDOException;
use classes\api\exception\server\InternalServerErrorException;

class DbConnection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    } # To prevent instantiation
    private function __clone()
    {
    } # To prevent cloning

    static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );
                # Set PDO to throw exceptions on db errors.
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new InternalServerErrorException('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
