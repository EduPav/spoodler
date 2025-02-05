<?php

namespace tests\api;

use classes\api\exception\client\BadRequestException;
use classes\api\exception\server\InternalServerErrorException;
use PHPUnit\Framework\TestCase;
use classes\api\Api;
use flight\Engine;
use Monolog\Logger;
use flight\net\Request;
use flight\net\Response;
use Exception;

class ApiTest extends TestCase
{
    private $engineMock;
    private $loggerMock;
    private $responseMock;

    protected function setUp(): void
    {
        $this->engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['sendSuccess', 'sendError', 'request', 'response', 'start'])
            ->getMock();

        $this->loggerMock = $this->createMock(Logger::class);

        $this->responseMock = $this->createMock(Response::class);

        $this->engineMock->method('request')->willReturn(new Request());
        $this->engineMock->method('response')->willReturn($this->responseMock);
    }

    function testRunSuccess(): void
    {
        $this->engineMock->expects($this->once())
            ->method('start');
        $this->engineMock->expects($this->never())
            ->method('sendError');

        $api = new Api($this->engineMock, $this->loggerMock);
        $api->run();
    }

    function testRunClientException(): void
    {
        $this->loggerMock->expects($this->once())
            ->method('warning');

        $this->engineMock->expects($this->once())
            ->method('start')
            ->will($this->throwException(new BadRequestException("Bad Request")));

        $this->engineMock->expects($this->once())
            ->method('sendError')
            ->with("Bad Request", 400);

        $api = new Api($this->engineMock, $this->loggerMock);
        $api->run();
    }

    function testRunServerException(): void
    {
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->engineMock->expects($this->once())
            ->method('start')
            ->will($this->throwException(new InternalServerErrorException('Confidential error information')));

        $this->engineMock->expects($this->once())
            ->method('sendError')
            ->with("Internal error when handling request", 500);

        $api = new Api($this->engineMock, $this->loggerMock);
        $api->run();
    }

    function testRunGenericThrowable(): void
    {
        $this->loggerMock->expects($this->once())
            ->method('error');

        $this->engineMock->expects($this->once())
            ->method('start')
            ->will($this->throwException(new Exception("Generic error")));

        $this->engineMock->expects($this->once())
            ->method('sendError')
            ->with("Internal error when handling request", 500);

        $api = new Api($this->engineMock, $this->loggerMock);
        $api->run();
    }
}
