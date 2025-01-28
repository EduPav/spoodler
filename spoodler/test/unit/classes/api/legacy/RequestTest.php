<?php

namespace classes\api\legacy;

use PHPUnit\Framework\TestCase;
use classes\api\legacy\Request;

class RequestTest extends TestCase
{
    public function testGetQueryParameters(): void
    {
        $queryParameters = ["param1" => "value1", "param2" => "value2"];
        $body = ["key" => "value"];

        $request = new Request($queryParameters, $body);

        $this->assertSame($queryParameters, $request->getQueryParameters());
    }

    public function testGetBody(): void
    {
        $queryParameters = ["param1" => "value1", "param2" => "value2"];
        $body = ["key" => "value"];

        $request = new Request($queryParameters, $body);

        $this->assertSame($body, $request->getBody());
    }

    public function testEmptyQueryParametersAndBody(): void
    {
        $request = new Request();

        $this->assertSame([], $request->getQueryParameters());
        $this->assertSame([], $request->getBody());
    }
}
