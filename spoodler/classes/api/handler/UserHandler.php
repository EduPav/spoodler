<?php

namespace classes\api\handler;

use classes\api\exception\client\BadRequestException;
use classes\api\exception\client\NotFoundException;
use classes\api\exception\client\UnauthorizedException;
use classes\api\exception\server\InternalServerErrorException;
use classes\utils\UserInputHandler;
use classes\db\UserTable;
use Firebase\JWT\JWT;
use flight\Engine;

class UserHandler
{
    private $app;
    private $userInputHandler;
    private $userTable;

    function __construct(Engine $app, UserTable $userTable)
    {
        $this->app = $app;
        $this->userInputHandler = new UserInputHandler();
        $this->userTable = $userTable;
    }

    function getMe(): void
    {
        $userId = $this->app->get('userId');
        $this->assertValidUserId($userId);
        $user = $this->userTable->getById($userId);
        $this->assertUserFetched($user);
        $this->app->sendSuccess(['email' => $user['email']]);
    }

    private function assertUserFetched(mixed $user): void
    {
        if (empty($user)) {
            throw new UnauthorizedException('User not found');
        }
    }

    private function assertValidUserId(?int $userId): void
    {
        if (!$userId) {
            throw new UnauthorizedException('Not authenticated');
        }
    }

    function loginUser(): void
    {
        $data = $this->app->request()->data->getData();
        $email = $this->userInputHandler->requireSanitizeValidate($data, "email", "email");
        $password = $this->userInputHandler->requireSanitizeValidate($data, "password", "string");

        $user = $this->userTable->getByUniqueField('email', $email);
        $this->assertValidCredentials($user, $password);
        $jwtToken = $this->createAuthToken($user['id']);
        $this->app->sendSuccess(['email' => $user['email'], 'token' => $jwtToken]);
    }

    function registerUser(): void
    {
        $data = $this->app->request()->data->getData();
        $email = $this->userInputHandler->requireSanitizeValidate($data, "email", "email");
        $password = $this->userInputHandler->requireSanitizeValidate($data, "password", "string");
        $this->assertEmailNotRegistered($email);
        $userId = $this->createUser($email, $password);
        $this->assertUserRegisteredSuccessfully($userId);
        $this->app->sendSuccess(['email' => $email], 201);
    }

    private function assertValidCredentials(?array $user, string $password): void
    {
        if (!$user || !password_verify($password, $user['password'])) {
            throw new UnauthorizedException("Invalid email or password");
        }
    }

    private function createAuthToken(int $userId): string
    {
        $issuedAt = time();
        $payload = [
            'id' => $userId,
            'iat' => $issuedAt,
            'exp' => $issuedAt + $GLOBALS['config']['api']['JWTExpiration']
        ];
        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }


    private function assertEmailNotRegistered(string $email): void
    {
        try {
            $this->userTable->getByUniqueField('email', $email);
            throw new BadRequestException('Email already registered');
        } catch (NotFoundException $e) {
            return;
        }
    }

    private function assertUserRegisteredSuccessfully(?int $userId): void
    {
        if (!$userId) {
            throw new InternalServerErrorException('Could not register user');
        }
    }

    private function createUser(string $email, string $password): int
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->userTable->create([
            'email' => $email,
            'password' => $hashedPassword,
        ]);
    }
}
