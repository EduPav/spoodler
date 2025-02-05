<?php

namespace classes\api;

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

    function run(): void
    {
        try {
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