<?php

use PHPUnit\Framework\TestCase;
use classes\db\DbConnection;

class DbConnectionTest extends TestCase
{
    function testGetInstanceExpectCorrectInstance()
    {
        // Test that the getInstance method returns a PDO instance.
        $dbConnection = DbConnection::getInstance();
        $this->assertInstanceOf(PDO::class, $dbConnection);
    }
}