<?php

namespace classes\api\handler;

use classes\api\exception\client\BadRequestException;
use PHPUnit\Framework\TestCase;
use classes\api\handler\ErrorLogHandler;
use classes\db\ErrorLogTable;
use flight\Engine;

class ErrorLogHandlerTest extends TestCase
{
    public function testGetAllErrors(): void
    {
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
        $handler = new ErrorLogHandler($engineMock, $errorTableMock);
        $handler->getAllErrors();
    }

    public function testGetErrorById(): void
    {
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
        $handler = new ErrorLogHandler($engineMock, $errorTableMock);
        $handler->getErrorById('123');
    }

    public function testGetErrorByIdWithInvalidIdExpectException(): void
    {
        $engineMock = $this->createMock(Engine::class);
        $errorTableMock = $this->createMock(ErrorLogTable::class);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("id must be an integer: id='a23'");
        // Execute
        $handler = new ErrorLogHandler($engineMock, $errorTableMock);
        $handler->getErrorById('a23');
    }
}
