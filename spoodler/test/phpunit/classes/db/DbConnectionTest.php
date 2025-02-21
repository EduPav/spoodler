<?php

namespace classes\db;

use PHPUnit\Framework\TestCase;
use classes\db\DbConnection;
use PDO;

class DbConnectionTest extends TestCase
{
    function testGetInstanceExpectCorrectInstance()
    {
        // Test that the getInstance method returns a PDO instance.
        $dbConnection = DbConnection::getInstance();
        $this->assertInstanceOf(PDO::class, $dbConnection);
    }
}