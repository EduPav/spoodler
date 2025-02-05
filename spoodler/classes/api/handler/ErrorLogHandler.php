<?php

namespace classes\api\handler;

use classes\utils\UserInputHandler;
use classes\db\ErrorLogTable;
use flight\Engine;

class ErrorLogHandler
{
    private Engine $app;
    private UserInputHandler $userInputHandler;
    private ErrorLogTable $errorTable;

    function __construct(Engine $app, ErrorLogTable $errorTable)
    {
        $this->app = $app;
        $this->userInputHandler = new UserInputHandler();
        $this->errorTable = $errorTable;
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
        $this->app->sendSuccess($error);
    }
}


