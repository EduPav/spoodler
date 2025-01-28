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

    public function testCreateWithInvalidColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Invalid column: madeUpColumn for create in users table");
        $userTable = new UserTable();
        $userTable->create([
            "username" => "admin",
            "madeUpColumn" => "admin@yahoo.com.ar"
        ]);
    }

    public function testCreateWithoutRequiredColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Missing required column: username for create in users table");
        $userTable = new UserTable();
        $userTable->create([]);
    }
}
