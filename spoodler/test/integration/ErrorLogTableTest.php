<?php

use classes\api\exception\client\NotFoundException;
use classes\api\exception\server\InternalServerErrorException;
use PHPUnit\Framework\TestCase;
use classes\db\ErrorLogTable;
use classes\db\DbConnection;

// This test class also helps us test BaseModel, as it was an abstract class.
class ErrorLogTableTest extends TestCase
{
    private ErrorLogTable $errorLogTable;

    protected function setUp(): void
    {
        // Initialize the ErrorLog class
        $this->errorLogTable = new ErrorLogTable();

        // Clear the table before each test
        $db = DbConnection::getInstance();
        $db->exec("TRUNCATE TABLE {$this->errorLogTable->getTableName()}");
    }

    private function createErrorLog(int $messageNumber = 1)
    {
        return $this->errorLogTable->create([
            "message" => "Test error message $messageNumber",
            "file" => "spoodler/test.php",
            "description" => "This is a test error message.",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    function testCreateErrorLogExpectFirstIndex(): void
    {
        $id = $this->createErrorLog(1);
        $this->assertEquals(1, $id);
    }

    function testCreate2ErrorLogsExpectSecondIndex(): void
    {
        $this->createErrorLog(1);
        $id = $this->createErrorLog(2);
        $this->assertEquals(2, $id);
    }

    function testCreateWithInvalidColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Invalid column: madeUpColumn for create in errors table");
        $this->errorLogTable->create([
            "message" => "Test error message",
            "file" => "spoodler/test.php",
            "madeUpColumn" => "This is a test error message.",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    function testCreateWithoutRequiredColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Missing required column: description for create in errors table");
        $this->errorLogTable->create([
            "message" => "Test error message",
            "file" => "spoodler/test.php",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    function testGetAllErrorLogsExpectLogsArray(): void
    {
        // create mock data
        $this->createErrorLog(1);
        $this->createErrorLog(2);
        $logs = $this->errorLogTable->getAll();
        $this->assertEquals([
            [
                "message" => "Test error message 1",
                "file" => "spoodler/test.php",
                "description" => "This is a test error message.",
                "created_at" => "2025-01-23 20:15:00",
                "id" => 1
            ],
            [
                "message" => "Test error message 2",
                "file" => "spoodler/test.php",
                "description" => "This is a test error message.",
                "created_at" => "2025-01-23 20:15:00",
                "id" => 2
            ]
        ], $logs);
    }

    function testGetByIdExpectLog(): void
    {
        $this->createErrorLog(1);
        $id = $this->createErrorLog(2);
        $log = $this->errorLogTable->getById($id);

        $this->assertEquals(
            [
                "message" => "Test error message 2",
                "file" => "spoodler/test.php",
                "description" => "This is a test error message.",
                "created_at" => "2025-01-23 20:15:00",
                "id" => 2
            ],
            $log
        );
    }

    function testGetByIdExpectNotFound(): void
    {
        $this->createErrorLog(1);

        $this->expectException(NotFoundException::class);
        $this->errorLogTable->getById(2);
    }

    function testGetTableNameExpectTableName()
    {
        $this->assertEquals("errors", $this->errorLogTable->getTableName());
    }

    function testUpdateErrorLogExpectSuccess(): void
    {
        // Create a log entry
        $id = $this->createErrorLog(1);

        // Update the log entry
        $updated = $this->errorLogTable->update($id, [
            "message" => "Updated error message",
            "file" => "spoodler/updated_test.php",
            "description" => "This is an updated test error message.",
            "created_at" => "2025-01-23 21:15:00"
        ]);

        $this->assertTrue($updated);

        // Verify the update
        $log = $this->errorLogTable->getById($id);

        $this->assertEquals(
            [
                "message" => "Updated error message",
                "file" => "spoodler/updated_test.php",
                "description" => "This is an updated test error message.",
                "created_at" => "2025-01-23 21:15:00",
                "id" => $id
            ],
            $log
        );
    }

    function testUpdateErrorLogExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage('Update errors with id=9999 failed');

        // Attempt to update a non-existing log entry
        $this->errorLogTable->update(9999, [
            "message" => "Non-existing error",
            "file" => "non_existing_test.php",
            "description" => "Trying to update a non-existing log.",
            "created_at" => "2025-01-23 21:15:00"
        ]);
    }

    function testDeleteErrorLogExpectSuccess(): void
    {
        // Create a log entry
        $id = $this->createErrorLog(1);

        // Delete the log entry
        $deleted = $this->errorLogTable->delete($id);

        $this->assertTrue($deleted);

        // Verify the deletion
        $this->expectException(NotFoundException::class);
        $this->errorLogTable->getById($id);
    }

    function testDeleteErrorLogExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage('Delete errors with id=9999 failed');

        // Attempt to delete a non-existing log entry
        $this->errorLogTable->delete(9999);
    }
}
