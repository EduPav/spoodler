<?php

namespace classes\api\exception\client;

use classes\api\exception\client\ClientException;

class NotFoundException extends \Exception implements ClientException
{
    protected $code = 404;
}