<?php

namespace classes\db;

class UserTable extends BaseModel
{
    public function getTableName(): string
    {
        return 'users';
    }
}
