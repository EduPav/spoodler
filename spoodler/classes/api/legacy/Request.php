<?php

namespace classes\api\legacy;

class Request
{
    private $queryParameters;
    private $body;

    function __construct(array $queryParameters = [], array $body = [])
    {
        $this->queryParameters = $queryParameters;
        $this->body = $body;
    }

    function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    function getBody(): array
    {
        return $this->body;
    }
}
