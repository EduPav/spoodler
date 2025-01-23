<?php

namespace classes\api\exception\server;

use classes\api\exception\server\ServerException;

class InternalServerErrorException extends \Exception implements ServerException
{
    protected $code = 500;
}