<?php

namespace classes\logger;

use classes\db\ErrorLogTable;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class PDOHandler extends AbstractProcessingHandler
{
    private $errorTable;

    function __construct(ErrorLogTable $errorTable)
    {
        $this->errorTable = $errorTable;
        parent::__construct(Logger::ERROR, true);
    }

    protected function write(LogRecord $record): void
    {
        $data = [
            'message' => substr($record->context['shortMessage'] ?? "Undetermined", 0, 255), // Limit message to VARCHAR(255)
            'file' => str_replace('/var/www/html/', '', $record->context['file'] ?? 'Undetermined'), // File name (optional in context)
            'description' => $record->message ?? 'No information',
            'created_at' => $record->datetime
                ->setTimezone(new \DateTimeZone($GLOBALS['config']["timeZone"])) // Adjusted to Arg time
                ->format('Y-m-d H:i:s'),
        ];
        $this->errorTable->create($data);
    }
}
