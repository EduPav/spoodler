<?php

use classes\db\UserTable;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetTableNameExpectTableName()
    {
        $userTable = new UserTable();
        $this->assertEquals("users", $userTable->getTableName());
    }
}
