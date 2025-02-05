<?php

namespace classes\db;

class ErrorLogTable extends BaseModel
{
    function getTableName(): string
    {
        return 'errors';
    }
}
