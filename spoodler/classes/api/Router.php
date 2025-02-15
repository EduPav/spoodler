<?php

namespace classes\api;

use classes\api\handler\ErrorLogHandler;
use classes\api\handler\UserHandler;
use classes\api\middleware\AuthMiddleware;
use classes\db\ErrorLogTable;
use classes\db\UserTable;
use flight\Engine;

class Router
{
    private $authMiddleware;

    function __construct(AuthMiddleware $authMiddleware)
    {
        $this->authMiddleware = $authMiddleware;
    }

    function buildRoutes(Engine $app): void
    {
        $router = $app->router();
        $router->group('/api', function () use ($router, $app) {
            $errorHandler = new ErrorLogHandler($app, new ErrorLogTable());
            $router->get('/errors', [$errorHandler, 'getAllErrors']);
            $router->get('/errors/@id', [$errorHandler, 'getErrorById']);
            $userHandler = new UserHandler($app, new UserTable());
            $router->get('/users/getme', [$userHandler, 'getMe']);
            $router->post('/users/login', [$userHandler, 'loginUser']);
            $router->post('/users/register', [$userHandler, 'registerUser']);
        }, [$this->authMiddleware]);
    }
}

