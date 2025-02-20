<?php

namespace classes\api\handler;

use classes\advice\OpenAIAdviceProvider;
use classes\api\exception\client\NotFoundException;
use classes\utils\UserInputHandler;
use classes\db\ErrorLogTable;
use flight\Engine;
use classes\advice\AdviceService;
use Monolog\Logger;

class ErrorLogHandler
{
    private $app;
    private $userInputHandler;
    private $errorTable;
    private $logger;

    function __construct(Engine $app, ErrorLogTable $errorTable, Logger $logger)
    {
        $this->app = $app;
        $this->userInputHandler = new UserInputHandler();
        $this->errorTable = $errorTable;
        $this->logger = $logger;
    }

    function getAllErrors(): void
    {
        $errors = $this->errorTable->getAll();
        $this->app->sendSuccess($errors);
    }

    function getErrorById(mixed $id): void
    {
        $this->userInputHandler->assertInt($id, "id");
        $error = $this->errorTable->getById($id);
        $this->assertErrorFetched($error);
        $this->app->sendSuccess($error);
    }

    private function assertErrorFetched(mixed $error)
    {
        if (empty($error)) {
            throw new NotFoundException('Error not found');
        }
    }

    function getErrorAdvice(mixed $id): void
    {
        $this->userInputHandler->assertInt($id, "id");
        $error = $this->errorTable->getById($id);
        $this->assertErrorFetched($error);
        $adviceService = new AdviceService(new OpenAIAdviceProvider($this->logger));
        $advice = $adviceService->getAdviceForError($error); // As this might start returning an array, line below could need to change
        $this->app->sendSuccess(["advice" => $advice]);
    }
}
