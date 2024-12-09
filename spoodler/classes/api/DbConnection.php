<?php

namespace classes\api;

use PDO;
use PDOException;

class DbConnection
{
    private static ?PDO $instance = null;

    private function __construct() {} # To prevent instantiation
    private function __clone() {} # To prevent cloning

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=db;dbname=spoodler;charset=utf8mb4',
                    'spoodler_user',
                    'spoodler_password'
                );
                # Set PDO to throw exceptions on db errors.
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            } catch (PDOException $e) {
                throw new \RuntimeException('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
