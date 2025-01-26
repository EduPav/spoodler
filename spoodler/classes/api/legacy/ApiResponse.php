<?php

namespace classes\api\legacy;

class ApiResponse
{
    private $message;
    private $data;

    function __construct(string $message, array $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

    function getMessage(): string
    {
        return $this->message;
    }

    function getData(): array
    {
        return $this->data;
    }
}
