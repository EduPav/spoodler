<?php

namespace classes\logger;

use classes\logger\PDOHandler;
use classes\db\ErrorLogTable;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Level;
use PHPUnit\Framework\TestCase;

class PDOHandlerTest extends TestCase
{
    private $errorTableMock;
    private $pdoHandler;

    protected function setUp(): void
    {
        // Create a mock for the ErrorLogTable
        $this->errorTableMock = $this->createMock(ErrorLogTable::class);

        // Instantiate the PDOHandler with the mocked ErrorLogTable
        $this->pdoHandler = new PDOHandler($this->errorTableMock);
    }

    function testWriteCreatesCorrectData(): void
    {
        // Set up a LogRecord to simulate a log entry
        $logRecord = new LogRecord(
            new \DateTimeImmutable('2025-01-25 12:00:00', new \DateTimeZone('UTC')), // UTC time
            'test_channel',
            Level::Error,
            'Test error description',
            [
                'shortMessage' => 'Test short message',
                'file' => '/path/to/file.php',
            ]
        );

        // Define the expected data to be created
        $expectedData = [
            'message' => 'Test short message',
            'file' => '/path/to/file.php',
            'description' => 'Test error description',
            'created_at' => '2025-01-25 09:00:00', // Converted to Argentinian time (UTC-3)
        ];

        // Expect the create method to be called once with the expected data
        $this->errorTableMock
            ->expects($this->once())
            ->method('create')
            ->with($expectedData);

        // Call the write method indirectly to test
        $this->pdoHandler->handle($logRecord);
    }

    function testWriteHandlesMissingContextKeys(): void
    {
        // Set up a LogRecord without optional context keys
        $logRecord = new LogRecord(
            new \DateTimeImmutable('2025-01-25 12:00:00', new \DateTimeZone('UTC')), // UTC time
            'test_channel',
            Level::Error,
            'Test error description',
            [] // Empty context
        );

        // Define the expected data to be created
        $expectedData = [
            'message' => 'Undetermined',
            'file' => 'Undetermined',
            'description' => 'Test error description',
            'created_at' => '2025-01-25 09:00:00', // Converted to Argentinian time (UTC-3)
        ];

        // Expect the create method to be called once with the expected data
        $this->errorTableMock
            ->expects($this->once())
            ->method('create')
            ->with($expectedData);

        // Call the write method indirectly to test
        $this->pdoHandler->handle($logRecord);
    }

    function testWriteTruncatesLongMessages(): void
    {
        // Set up a LogRecord with a very long message
        $longMessage = str_repeat('A', 300); // 300 characters
        $logRecord = new LogRecord(
            new \DateTimeImmutable('2025-01-25 12:00:00', new \DateTimeZone('UTC')), // UTC time
            'test_channel',
            Level::Error,
            'Test error description',
            [
                'shortMessage' => $longMessage,
                'file' => '/path/to/file.php',
            ]
        );

        // Define the expected data to be created
        $expectedData = [
            'message' => str_repeat('A', 255), // Truncated to 255 characters
            'file' => '/path/to/file.php',
            'description' => 'Test error description',
            'created_at' => '2025-01-25 09:00:00', // Converted to Argentinian time (UTC-3)
        ];

        // Expect the create method to be called once with the expected data
        $this->errorTableMock
            ->expects($this->once())
            ->method('create')
            ->with($expectedData);

        // Call the write method to test
        $this->pdoHandler->handle($logRecord);
    }
}
