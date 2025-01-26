<?php

namespace classes\api\legacy\control;

use classes\api\legacy\Request;
use classes\api\legacy\ApiResponse;
use classes\api\legacy\render\Renderable;
use classes\api\legacy\control\Handleable;
use classes\api\exception\client\NotFoundException;
use classes\api\exception\client\ClientException;
use classes\api\exception\server\ServerException;
use Monolog\Logger;
use Throwable;

class LegacyController
{
    private $logger;
    private $renderer;
    private $handler;
    private $successStatusCode;

    function __construct(
        Logger $logger,
        Renderable $renderer,
        Handleable $handler,
        int $successStatusCode
    ) {
        $this->logger = $logger;
        $this->renderer = $renderer;
        $this->handler = $handler;
        $this->successStatusCode = $successStatusCode;
    }

    function handle(Request $request): string
    {
        try {
            $this->logger->info("Handling request...");
            $response = $this->getResponse(
                $this->successStatusCode,
                "",
                $this->handler->handle($request)
            );
            $this->logger->info("Rendering response...");
            $output = $this->renderer->renderSuccess($response);
        } catch (NotFoundException $e) {
            $this->handleClientError($e);
            $response = $this->getResponse($e->getCode(), $e->getMessage());
            $output = $this->renderer->renderNotFound($response);
        } catch (ClientException $e) {
            $this->handleClientError($e);
            $response = $this->getResponse($e->getCode(), $e->getMessage());
            $output = $this->renderer->renderError($response);
        } catch (ServerException $e) {
            $this->handleInternalError($e);
            $response = $this->getResponse(
                $e->getCode(),
                "Internal error when handling request"
            );
            $output = $this->renderer->renderError($response);
        } catch (Throwable $e) {
            $this->handleInternalError($e);
            $response = $this->getResponse(
                500,
                "Internal error when handling request"
            );
            $output = $this->renderer->renderError($response);
        }
        return $output;
    }

    private function getResponse(int $statusCode, string $message, array $data = []): ApiResponse
    {
        http_response_code($statusCode);
        $this->logger->info("Request handled", ["http_status_code" => $statusCode]);
        return new ApiResponse($message, $data);
    }

    private function handleClientError(ClientException $e): void
    {
        $this->logger->warning($e->getMessage(), [
            "shortMessage" => "Error when accessing endpoint",
            "file" => $e->getFile()
        ]);
    }

    private function handleInternalError(Throwable $e): void
    {
        $this->logger->error($e->getMessage(), [
            "shortMessage" => "Error when accessing endpoint",
            "file" => $e->getFile()
        ]);
    }
}
