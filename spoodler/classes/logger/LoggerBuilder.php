<?php

namespace classes\logger;

use classes\db\ErrorLogTable;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use classes\logger\PDOHandler;
use Monolog\ErrorHandler;

class LoggerBuilder
{
    private $logger;

    function __construct()
    {
        $this->logger = new MonologLogger('spoodler_logger');

        // Add a file handler for general logging
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/info.log', MonologLogger::INFO));

        // Add the custom PDOHandler for error logging
        try {
            $this->logger->pushHandler(new PDOHandler(new ErrorLogTable()));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
        // Register this logger as the global error and exception handler
        ErrorHandler::register($this->logger);
    }

    function getLogger(): MonologLogger
    {
        return $this->logger;
    }
}
