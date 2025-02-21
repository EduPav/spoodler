<?php

namespace classes\api;

use classes\api\handler\ErrorLogHandler;
use classes\api\handler\UserHandler;
use classes\api\middleware\AuthMiddleware;
use classes\db\ErrorLogTable;
use classes\db\UserTable;
use flight\Engine;
use Monolog\Logger;

class Router
{
    private $authMiddleware;
    private $logger;

    function __construct(AuthMiddleware $authMiddleware, Logger $logger)
    {
        $this->authMiddleware = $authMiddleware;
        $this->logger = $logger;
    }

    function buildRoutes(Engine $app): void
    {
        $router = $app->router();
        $router->group('/api', function () use ($router, $app) {
            $errorHandler = new ErrorLogHandler($app, new ErrorLogTable(), $this->logger);
            $router->get('/errors', [$errorHandler, 'getAllErrors']);
            $router->get('/errors/@id', [$errorHandler, 'getErrorById']);
            $router->get('/errors/@id/advice', [$errorHandler, 'getErrorAdvice']);
            $userHandler = new UserHandler($app, new UserTable());
            $router->get('/users/getme', [$userHandler, 'getMe']);
            $router->post('/users/login', [$userHandler, 'loginUser']);
            $router->post('/users/register', [$userHandler, 'registerUser']);
            // Handle undefined routes and methods
            $router->map('/(errors/.+|users/.+)', function () use ($app) {
                $app->sendError('Method not allowed', 405);
            });
            $router->map('/*', function () use ($app) {
                $app->sendError('Page not found', 404);
            });
        }, [$this->authMiddleware]);
    }
}

