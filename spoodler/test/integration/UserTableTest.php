<?php

use classes\api\exception\server\InternalServerErrorException;
use classes\db\UserTable;
use PHPUnit\Framework\TestCase;

class UserTableTest extends TestCase
{
    public function testGetTableNameExpectTableName()
    {
        $userTable = new UserTable();
        $this->assertEquals("users", $userTable->getTableName());
    }

    public function testInsertWithInvalidColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Invalid column: madeUpColumn for insert in users table");
        $userTable = new UserTable();
        $userTable->insert([
            "username" => "admin",
            "madeUpColumn" => "admin@yahoo.com.ar"
        ]);
    }

    public function testInsertWithoutRequiredColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Missing required column: username for insert in users table");
        $userTable = new UserTable();
        $userTable->insert([]);
    }
}
