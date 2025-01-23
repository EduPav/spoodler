<?php

namespace classes\db;

class ErrorLogTable extends BaseModel
{
    public function getTableName(): string
    {
        return 'errors';
    }
}
