<?php

namespace classes\api\legacy\control;

use classes\api\exception\client\BadRequestException;
use classes\api\exception\server\InternalServerErrorException;
use PHPUnit\Framework\TestCase;
use classes\api\legacy\control\LegacyController;
use classes\api\legacy\Request;
use classes\api\legacy\ApiResponse;
use classes\api\legacy\render\Renderable;
use classes\api\legacy\control\Handleable;
use classes\api\exception\client\NotFoundException;
use Monolog\Logger;

class LegacyControllerTest extends TestCase
{
    function testHandleSuccessResponseExpectMockCallsAndReturnRenderedSuccess(): void
    {
        $loggerMock = $this->createMock(Logger::class);

        $requestMock = $this->createMock(Request::class);

        $handlerMock = $this->createMock(Handleable::class);
        $handlerMock->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->willReturn(['key' => 'value']);

        $rendererMock = $this->createMock(Renderable::class);
        $rendererMock->expects($this->once())
            ->method('renderSuccess')
            ->with(new ApiResponse('', ['key' => 'value']))
            ->willReturn('Rendered Success');

        $controller = new LegacyController($loggerMock, $rendererMock, $handlerMock, 200);
        $output = $controller->handle($requestMock);

        $this->assertSame('Rendered Success', $output);
    }

    function testHandleNotFoundExceptionExpectMockCallsAndReturnNotFound(): void
    {
        $loggerMock = $this->createMock(Logger::class);
        $loggerMock->expects($this->once())->method('warning');

        $requestMock = $this->createMock(Request::class);

        $handlerMock = $this->createMock(Handleable::class);
        $handlerMock->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->willThrowException(new NotFoundException('Element Not Found'));

        $rendererMock = $this->createMock(Renderable::class);
        $rendererMock->expects($this->once())
            ->method('renderNotFound')
            ->with(new ApiResponse('Element Not Found', []))
            ->willReturn('Not Found Rendered');

        $controller = new LegacyController($loggerMock, $rendererMock, $handlerMock, 200);
        $output = $controller->handle($requestMock);

        $this->assertSame('Not Found Rendered', $output);
    }

    function testHandleClientExceptionExpectMockCallsAndReturnClientError(): void
    {
        $loggerMock = $this->createMock(Logger::class);
        $loggerMock->expects($this->once())->method('warning');

        $requestMock = $this->createMock(Request::class);

        $handlerMock = $this->createMock(Handleable::class);
        $handlerMock->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->willThrowException(new BadRequestException('Invalid Input'));

        $rendererMock = $this->createMock(Renderable::class);
        $rendererMock->expects($this->once())
            ->method('renderError')
            ->with(new ApiResponse('Invalid Input', []))
            ->willReturn('Client Error Render');

        $controller = new LegacyController($loggerMock, $rendererMock, $handlerMock, 200);
        $output = $controller->handle($requestMock);

        $this->assertSame('Client Error Render', $output);
    }

    function testHandleServerExceptionExpectMockCallsAndReturnInternalServerError(): void
    {
        $loggerMock = $this->createMock(Logger::class);
        $loggerMock->expects($this->once())->method('error');

        $requestMock = $this->createMock(Request::class);

        $handlerMock = $this->createMock(Handleable::class);
        $handlerMock->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->willThrowException(new InternalServerErrorException(
                'Confidential server data regarding this error'
            ));

        $rendererMock = $this->createMock(Renderable::class);
        $rendererMock->expects($this->once())
            ->method('renderError')
            ->with(new ApiResponse('Internal error when handling request', []))
            ->willReturn('Generic Error Render');

        $controller = new LegacyController($loggerMock, $rendererMock, $handlerMock, 200);
        $output = $controller->handle($requestMock);

        $this->assertSame('Generic Error Render', $output);
    }

    function testHandleGenericThrowableExpectMockCallsAndReturnGenericError(): void
    {
        $loggerMock = $this->createMock(Logger::class);
        $loggerMock->expects($this->once())->method('error');

        $requestMock = $this->createMock(Request::class);

        $handlerMock = $this->createMock(Handleable::class);
        $handlerMock->expects($this->once())
            ->method('handle')
            ->with($requestMock)
            ->willThrowException(new \Exception('Generic Error', 500));

        $rendererMock = $this->createMock(Renderable::class);
        $rendererMock->expects($this->once())
            ->method('renderError')
            ->with(new ApiResponse('Internal error when handling request', []))
            ->willReturn('Generic Error Render');

        $controller = new LegacyController($loggerMock, $rendererMock, $handlerMock, 200);
        $output = $controller->handle($requestMock);

        $this->assertSame('Generic Error Render', $output);
    }
}