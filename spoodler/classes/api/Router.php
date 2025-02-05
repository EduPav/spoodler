<?php

namespace classes\api;

use classes\api\handler\ErrorLogHandler;
use classes\db\ErrorLogTable;
use flight\Engine;

class Router
{
    function buildRoutes(Engine $app): void
    {
        $router = $app->router();
        $router->group('/api', function () use ($router, $app) {
            $errorHandler = new ErrorLogHandler($app, new ErrorLogTable());
            $router->get('/errors', [$errorHandler, 'getAllErrors']);
            $router->get('/errors/@id', [$errorHandler, 'getErrorById']);
        });
    }
}

