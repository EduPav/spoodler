<?php

namespace classes\report;

use classes\api\exception\client\NotFoundException;
use classes\api\legacy\control\Handleable;
use classes\api\legacy\Request;
use classes\db\ErrorLogTable;
use classes\utils\UserInputHandler;

class LegacyHandler implements Handleable
{

    private $errorLogTable;
    private $userInputHandler;

    function __construct(ErrorLogTable $errorLogTable, UserInputHandler $userInputHandler)
    {
        $this->errorLogTable = $errorLogTable;
        $this->userInputHandler = $userInputHandler;
    }

    function handle(Request $request): array
    {
        $queryParameters = $request->getQueryParameters();
        $id = $this->userInputHandler->requireSanitizeValidate($queryParameters, 'id', 'integer');
        $report = $this->errorLogTable->getById($id);
        $this->assertErrorFetched($report);
        return $report;
    }

    private function assertErrorFetched(mixed $error)
    {
        if (empty($error)) {
            throw new NotFoundException('Error not found');
        }
    }
}