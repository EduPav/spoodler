<?php

namespace classes\api\legacy\render;

use PHPUnit\Framework\TestCase;
use classes\api\legacy\render\Json;
use classes\api\legacy\ApiResponse;
use classes\api\legacy\Header;

class JsonTest extends TestCase
{
    function testConstructJsonExpectCallHeaderWithJsonContent()
    {
        $headerMock = $this->createMock(Header::class);
        $headerMock->expects($this->once())
            ->method('set')
            ->with(Header::JSON_CONTENT);

        new Json($headerMock);
    }

    function testRenderSuccessExpectJsonEncodedResponse(): void
    {
        $headerMock = $this->createMock(Header::class);
        $json = new Json($headerMock);
        $data = ["key1" => "value1", "key2" => "value2"];
        $response = new ApiResponse("Success", $data);

        $expected = json_encode([
            "message" => "Success",
            "data" => $data
        ]);

        $this->assertSame($expected, $json->renderSuccess($response));
    }

    function testRenderErrorExpectJsonEncodedErrorMessage(): void
    {
        $headerMock = $this->createMock(Header::class);
        $json = new Json($headerMock);
        $response = new ApiResponse("Error occurred", []);

        $expected = json_encode([
            "message" => "Error occurred",
            "data" => []
        ]);

        $this->assertSame($expected, $json->renderError($response));
    }

    function testRenderNotFoundExpectJsonEncodedErrorMessage(): void
    {
        $headerMock = $this->createMock(Header::class);
        $json = new Json($headerMock);
        $response = new ApiResponse("Resource not found", []);

        $expected = json_encode([
            "message" => "Resource not found",
            "data" => []
        ]);

        $this->assertSame($expected, $json->renderNotFound($response));
    }
}