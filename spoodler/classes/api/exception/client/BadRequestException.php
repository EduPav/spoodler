<?php

namespace classes\api\exception\client;

use classes\api\exception\client\ClientException;

class BadRequestException extends \Exception implements ClientException {
    protected $code = 400;
}