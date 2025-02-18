<?php

namespace classes\api;

use classes\api\middleware\AuthMiddleware;
use classes\api\Router;
use classes\api\exception\client\ClientException;
use classes\api\exception\server\ServerException;
use flight\Engine;
use Monolog\Logger;
use Throwable;

class Api
{
    private $logger;
    private $request;
    private $response;
    private $app;

    function __construct(Engine $app, Logger $logger)
    {
        $this->app = $app;
        $this->logger = $logger;
        $this->request = $this->app->request();
        $this->response = $this->app->response();
    }

    private function init(): void
    {
        // Authentication and Routing
        $authMiddleware = new AuthMiddleware($_ENV['JWT_SECRET'], $this->app, $this->logger);
        $router = new Router($authMiddleware, $this->logger);
        $router->buildRoutes($this->app);

        // CORS
        $this->app->response()->header("Access-Control-Allow-Origin: *"); // Allows any domain (you can specify a specific one)
        $this->app->response()->header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allowed request types
        $this->app->response()->header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers
    }

    function run(): void
    {
        try {
            $this->init();
            $this->logger->info(
                "Request to REST API received",
                [
                    // "http_method" => $this->request->method,
                    "http_uri" => $this->request->getVar('REQUEST_URI')
                ]
            );
            $this->app->start();
        } catch (ClientException $e) {
            $this->handleClientError($e);
        } catch (ServerException $e) {
            $this->handleInternalError($e, $e->getCode());
        } catch (Throwable $e) {
            $this->handleInternalError($e, 500);
        }
        $this->logger->info("Request handled", ["http_status_code" => $this->response->status()]);
    }

    private function handleInternalError(Throwable $e, int $statusCode): void
    {
        $this->logger->error($e->getMessage(), [
            "shortMessage" => "Error when accessing endpoint",
            "file" => $e->getFile()
        ]);
        $this->app->sendError("Internal error when handling request", $statusCode);
    }

    private function handleClientError(ClientException $e): void
    {
        $this->logger->warning($e->getMessage(), [
            "shortMessage" => "Error when accessing endpoint",
            "file" => $e->getFile()
        ]);
        $this->app->sendError($e->getMessage(), $e->getCode());
    }
}