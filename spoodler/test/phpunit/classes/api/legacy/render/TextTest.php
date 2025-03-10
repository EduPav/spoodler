<?php

namespace classes\api\legacy\render;

use PHPUnit\Framework\TestCase;
use classes\api\legacy\render\Text;
use classes\api\legacy\ApiResponse;
use classes\api\legacy\Header;

class TextTest extends TestCase
{
    function testConstructTextExpectCallHeaderWithTextContent()
    {
        $headerMock = $this->createMock(Header::class);
        $headerMock->expects($this->once())
            ->method('set')
            ->with(Header::TEXT_CONTENT);

        new Text($headerMock);
    }

    function testRenderSuccessExpectJoinLines(): void
    {
        $headerMock = $this->createMock(Header::class);
        $text = new Text($headerMock);
        $data = ["Line 1", "Line 2", "Line 3"];
        $response = new ApiResponse("Success", $data);

        $this->assertSame("Line 1\nLine 2\nLine 3", $text->renderSuccess($response));
    }

    function testRenderErrorExpectErrorMessage(): void
    {
        $headerMock = $this->createMock(Header::class);
        $text = new Text($headerMock);
        $response = new ApiResponse("Error occurred", []);

        $this->assertSame("Error occurred", $text->renderError($response));
    }

    function testRenderNotFoundExpectErrorMessage(): void
    {
        $headerMock = $this->createMock(Header::class);
        $text = new Text($headerMock);
        $response = new ApiResponse("Resource not found", []);

        $this->assertSame("Resource not found", $text->renderNotFound($response));
    }
}
