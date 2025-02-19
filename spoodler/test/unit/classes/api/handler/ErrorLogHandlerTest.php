<?php

namespace classes\api\handler;

use classes\api\exception\client\BadRequestException;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use classes\api\handler\ErrorLogHandler;
use classes\db\ErrorLogTable;
use flight\Engine;

class ErrorLogHandlerTest extends TestCase
{
    function testGetAllErrors(): void
    {
        $logger = $this->createMock(Logger::class);
        $engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['sendSuccess'])
            ->getMock();
        $errorTableMock = $this->createMock(ErrorLogTable::class);
        // Mock the database call
        $fakeErrors = [
            ['id' => 1, 'message' => 'First error'],
            ['id' => 2, 'message' => 'Second error']
        ];

        $errorTableMock->expects($this->once())
            ->method('getAll')
            ->willReturn($fakeErrors);
        $engineMock->expects($this->once())
            ->method('sendSuccess')
            ->with($this->equalTo($fakeErrors));

        // Execute
        $handler = new ErrorLogHandler($engineMock, $errorTableMock, $logger);
        $handler->getAllErrors();
    }

    function testGetErrorById(): void
    {
        $logger = $this->createMock(Logger::class);
        $engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['sendSuccess'])
            ->getMock();
        $errorTableMock = $this->createMock(ErrorLogTable::class);
        $fakeError = ['id' => "123", 'message' => 'Something broke'];

        $errorTableMock->expects($this->once())
            ->method('getById')
            ->with(123)
            ->willReturn($fakeError);

        $engineMock->expects($this->once())
            ->method('sendSuccess')
            ->with($this->equalTo($fakeError));

        // Execute
        $handler = new ErrorLogHandler($engineMock, $errorTableMock, $logger);
        $handler->getErrorById('123');
    }

    function testGetErrorByIdWithInvalidIdExpectException(): void
    {
        $logger = $this->createMock(Logger::class);
        $engineMock = $this->createMock(Engine::class);
        $errorTableMock = $this->createMock(ErrorLogTable::class);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("id must be an integer: id='a23'");

        $handler = new ErrorLogHandler($engineMock, $errorTableMock, $logger);
        $handler->getErrorById('a23');
    }

    function testGetErrorAdviceWithInvalidIdExpectException(): void
    {
        $logger = $this->createMock(Logger::class);
        $engineMock = $this->createMock(Engine::class);
        $errorTableMock = $this->createMock(ErrorLogTable::class);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("id must be an integer: id='a23'");

        $handler = new ErrorLogHandler($engineMock, $errorTableMock, $logger);
        $handler->getErrorAdvice('a23');
    }

}
