<?php

namespace classes\db;

class UserTable extends BaseModel
{
    function getTableName(): string
    {
        return 'users';
    }
}
