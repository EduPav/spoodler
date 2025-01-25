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

    private function insertErrorLog(int $messageNumber = 1)
    {
        return $this->errorLogTable->insert([
            "message" => "Test error message $messageNumber",
            "file" => "spoodler/test.php",
            "description" => "This is a test error message.",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    public function testInsertErrorLogExpectFirstIndex(): void
    {
        $id = $this->insertErrorLog(1);
        $this->assertEquals(1, $id);
    }

    public function testInsert2ErrorLogsExpectSecondIndex(): void
    {
        $this->insertErrorLog(1);
        $id = $this->insertErrorLog(2);
        $this->assertEquals(2, $id);
    }

    public function testInsertWithInvalidColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Invalid column: madeUpColumn for insert in errors table");
        $this->errorLogTable->insert([
            "message" => "Test error message",
            "file" => "spoodler/test.php",
            "madeUpColumn" => "This is a test error message.",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    public function testInsertWithoutRequiredColumnExpectInternalServerError(): void
    {
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Missing required column: description for insert in errors table");
        $this->errorLogTable->insert([
            "message" => "Test error message",
            "file" => "spoodler/test.php",
            "created_at" => "2025-01-23 20:15:00"
        ]);
    }

    public function testGetAllErrorLogsExpectLogsArray(): void
    {
        // Insert mock data
        $this->insertErrorLog(1);
        $this->insertErrorLog(2);
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

    public function testGetByIdExpectLog(): void
    {
        $this->insertErrorLog(1);
        $id = $this->insertErrorLog(2);
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

    public function testGetByIdExpectNotFound(): void
    {
        $this->insertErrorLog(1);

        $this->expectException(NotFoundException::class);
        $this->errorLogTable->getById(2);
    }

    public function testGetTableNameExpectTableName()
    {
        $this->assertEquals("errors", $this->errorLogTable->getTableName());
    }
}
