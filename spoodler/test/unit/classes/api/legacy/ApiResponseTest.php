<?php

namespace classes\api\legacy;

use PHPUnit\Framework\TestCase;
use classes\api\legacy\ApiResponse;

class ApiResponseTest extends TestCase
{
    public function testGetMessage(): void
    {
        $message = "Success";
        $data = ["key" => "value"];

        $response = new ApiResponse($message, $data);

        $this->assertSame($message, $response->getMessage());
    }

    public function testGetData(): void
    {
        $message = "Success";
        $data = ["key" => "value"];

        $response = new ApiResponse($message, $data);

        $this->assertSame($data, $response->getData());
    }

    public function testEmptyInputs(): void
    {
        $message = "";
        $data = [];

        $response = new ApiResponse($message, $data);

        $this->assertSame($data, $response->getData());
        $this->assertSame($message, $response->getMessage());
    }
}
