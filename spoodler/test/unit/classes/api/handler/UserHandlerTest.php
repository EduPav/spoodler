<?php

namespace classesapi\api\handler;

use PHPUnit\Framework\TestCase;
use classes\api\handler\UserHandler;
use classes\db\UserTable;
use flight\Engine;
use classes\api\exception\client\UnauthorizedException;
use classes\api\exception\client\BadRequestException;
use classes\api\exception\client\NotFoundException;
use classes\api\exception\server\InternalServerErrorException;

class UserHandlerTest extends TestCase
{
    private $backupJwtSecret;
    private $backupJwtExpiration;

    protected function setUp(): void
    {
        $this->backupJwtExpiration = $GLOBALS['config']['api']['JWTExpiration'];
        $this->backupJwtSecret = $_ENV['JWT_SECRET'];

        // Set required globals for JWT creation.
        $_ENV['JWT_SECRET'] = 'testsecret';
        $GLOBALS['config']['api']['JWTExpiration'] = 3600;
    }

    protected function tearDown(): void
    {
        $_ENV['JWT_SECRET'] = $this->backupJwtSecret;
        $GLOBALS['config']['api']['JWTExpiration'] = $this->backupJwtExpiration;
    }


    private function mockEngineWithGet(string $getInput, ?int $getOutput)
    {
        $engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['sendSuccess'])
            ->onlyMethods(['get'])
            ->getMock();
        $engineMock->method('get')
            ->with($this->equalTo($getInput))
            ->willReturn($getOutput);
        return $engineMock;
    }

    private function mockEngineWithRequest(array $data)
    {
        $dataStub = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getData'])
            ->getMock();
        $dataStub->method('getData')->willReturn($data);

        $requestStub = new stdClass();
        $requestStub->data = $dataStub;

        $engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['sendSuccess', 'request'])
            ->getMock();
        $engineMock->method('request')->willReturn($requestStub);
        return $engineMock;
    }

    function testGetMeWithoutLoggingExpectUnauthorizedException()
    {
        $engineMock = $this->mockEngineWithGet('userId', null);
        $userTable = $this->createMock(UserTable::class);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Not authenticated');

        $handler = new UserHandler($engineMock, $userTable);
        $handler->getMe();
    }

    function testGetMeLoggedInExpectCallEngineSendSuccess()
    {
        $userId = 42;
        $userData = ['id' => $userId, 'email' => 'user@example.com', 'password' => 'confidentialValue'];
        $engineMock = $this->mockEngineWithGet('userId', $userId);
        $userTable = $this->createMock(UserTable::class);
        $userTable->method('getById')
            ->with($userId)
            ->willReturn($userData);

        $engineMock->expects($this->once())
            ->method('sendSuccess')
            ->with(['email' => 'user@example.com']);

        $handler = new UserHandler($engineMock, $userTable);
        $handler->getMe();
    }

    function testLoginUserWithInvalidEmailExpectUnauthorizedException()
    {
        $data = ['email' => 'nonexistent@example.com', 'password' => 'secret'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->willReturn(null);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Invalid email or password');

        $handler = new UserHandler($engineMock, $userTable);
        $handler->loginUser();
    }

    private function mockUserTable(string $email, string $password)
    {
        $userTable = $this->createMock(UserTable::class);
        $userRecord = [
            'id' => 1,
            'email' => 'user@example.com',
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        $userTable->method('getByUniqueField')
            ->with('email', $email)
            ->willReturn($userRecord);
        return $userTable;
    }
    function testLoginUserWithInvalidPasswordExpectUnauthorizedException()
    {
        $data = ['email' => 'user@example.com', 'password' => 'wrongpassword'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        $userRecord = [
            'id' => 1,
            'email' => 'user@example.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT)
        ];
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->willReturn($userRecord);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Invalid email or password');

        $handler = new UserHandler($engineMock, $userTable);
        $handler->loginUser();
    }

    function testLoginUserWithValidCredentialsExpectSendSuccess()
    {
        $data = ['email' => 'user@example.com', 'password' => 'secret'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        $userRecord = [
            'id' => 1,
            'email' => 'user@example.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT)
        ];
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->willReturn($userRecord);

        $engineMock->expects($this->once())
            ->method('sendSuccess')
            ->with($this->callback(function ($result) use ($userRecord) {
                return $result['email'] === $userRecord['email'] && !empty($result['token']);
            }));

        $handler = new UserHandler($engineMock, $userTable);
        $handler->loginUser();
    }

    function testRegisterUserWithAlreadyRegisteredEmailExpectBadRequestException()
    {
        $data = ['email' => 'user@example.com', 'password' => 'secret'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        $existingUser = ['id' => 1, 'email' => $data['email'], 'password' => 'hashed'];
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->willReturn($existingUser);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Email already registered');

        $handler = new UserHandler($engineMock, $userTable);
        $handler->registerUser();
    }

    function testRegisterUserWithCreationFailureExpectInternalServerErrorException()
    {
        $data = ['email' => 'newuser@example.com', 'password' => 'secret'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        // Simulate email not registered.
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->will($this->throwException(new NotFoundException()));
        // Simulate failure to create user.
        $userTable->method('create')->willReturn(0);

        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage('Could not register user');

        $handler = new UserHandler($engineMock, $userTable);
        $handler->registerUser();
    }

    function testRegisterUserWithValidDataExpectSendSuccess()
    {
        $data = ['email' => 'newuser@example.com', 'password' => 'secret'];
        $engineMock = $this->mockEngineWithRequest($data);
        $userTable = $this->createMock(UserTable::class);
        // Simulate email not registered.
        $userTable->method('getByUniqueField')
            ->with('email', $data['email'])
            ->will($this->throwException(new NotFoundException()));
        // Simulate successful user creation.
        $userTable->method('create')->willReturn(10);

        $engineMock->expects($this->once())
            ->method('sendSuccess')
            ->with($this->equalTo(['email' => $data['email']]), $this->equalTo(201));

        $handler = new UserHandler($engineMock, $userTable);
        $handler->registerUser();
    }
}
