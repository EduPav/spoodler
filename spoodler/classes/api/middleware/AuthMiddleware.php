<?php
namespace classes\api\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use flight\Engine;
use Monolog\Logger;

class AuthMiddleware
{
    private $secretKey;
    private $app;
    private $logger;

    function __construct(string $secretKey, Engine $app, Logger $logger)
    {
        $this->secretKey = $secretKey;
        $this->app = $app;
        $this->logger = $logger;
    }

    function before(): void
    {
        $path = $this->app->request()->url;
        $this->logger->info("Authenticating user", ["path" => $path]);

        // Only protect /api routes except login and register
        if (
            strpos($path, '/api') !== 0 ||
            preg_match('#^/api/users/(login|register)$#', $path)
        ) {
            return;
        }

        $authHeader = $this->app->request()->getHeader('Authorization');
        if (empty($authHeader)) {
            $this->app->sendError('Missing Authorization header', 401);
        }

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $this->app->sendError('Invalid Authorization header format', 401);
        }

        $token = $matches[1];
        try {
            $this->logger->info("Validating token", ["token" => $token]);
            $decoded = (array) JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $this->app->set('userId', $decoded['id']);
        } catch (\Exception $e) {
            $this->app->sendError('Unauthorized', 401);
        }
    }
}
