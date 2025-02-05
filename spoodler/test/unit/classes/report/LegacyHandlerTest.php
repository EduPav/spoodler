<?php

namespace classes\report;

use PHPUnit\Framework\TestCase;
use classes\api\exception\client\NotFoundException;
use classes\utils\UserInputHandler;
use classes\report\LegacyHandler;
use classes\db\ErrorLogTable;
use classes\api\legacy\Request;
use classes\api\exception\client\BadRequestException;

class LegacyHandlerTest extends TestCase
{
    function testHandleValidIdExpectReportReturned(): void
    {
        $exampleErrorReport = [
            'id' => 123,
            'message' => 'Undetermined',
            'file' => 'Undetermined',
            'description' => 'Uncaught Exception classes\\api\\...',
            'created_at' => "2025-01-25 14:43:24"
        ];
        $errorLogTableMock = $this->createMock(ErrorLogTable::class);
        $errorLogTableMock->expects($this->once())
            ->method('getById')
            ->with(123)
            ->willReturn($exampleErrorReport);

        $requestMock = $this->createMock(Request::class);
        $requestMock->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn(['id' => '123']);

        $handler = new LegacyHandler($errorLogTableMock, new UserInputHandler());
        $result = $handler->handle($requestMock);

        $this->assertSame($exampleErrorReport, $result);
    }

    function testHandleInvalidIdExpectBadRequestException(): void
    {
        $errorLogTableMock = $this->createMock(ErrorLogTable::class);
        $requestMock = $this->createMock(Request::class);
        $requestMock->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn(['id' => 'a']);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('id must be an int');

        $handler = new LegacyHandler($errorLogTableMock, new UserInputHandler());
        $handler->handle($requestMock);
    }

    function testHandleMissingIdExpectBadRequestException(): void
    {

        $errorLogTableMock = $this->createMock(ErrorLogTable::class);
        $requestMock = $this->createMock(Request::class);
        $requestMock->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn([]);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Parameter 'id' is required");

        $handler = new LegacyHandler($errorLogTableMock, new UserInputHandler());
        $handler->handle($requestMock);
    }

    function testHandleNotFoundIdExpectNotFoundException(): void
    {
        $errorLogTableMock = $this->createMock(ErrorLogTable::class);
        $errorLogTableMock->expects($this->once())
            ->method('getById')
            ->with(123)
            ->willThrowException(new NotFoundException('Record not found'));
        $requestMock = $this->createMock(Request::class);
        $requestMock->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn(['id' => '123']);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Record not found');

        $handler = new LegacyHandler($errorLogTableMock, new UserInputHandler());
        $handler->handle($requestMock);
    }
}
