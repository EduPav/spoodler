<?php

namespace classes\api\exception\client;

use classes\api\exception\client\ClientException;

class UnauthorizedException extends \Exception implements ClientException
{
    protected $code = 401;
}