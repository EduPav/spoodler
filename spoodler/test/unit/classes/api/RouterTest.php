<?php

namespace classes\api;

use classes\api\middleware\AuthMiddleware;
use PHPUnit\Framework\TestCase;
use classes\api\Router;
use flight\net\Router as FlightRouter;
use flight\Engine;

class RouterTest extends TestCase
{
    function testBuildRoutesCallsRouterGroupOnce()
    {
        $flightRouterMock = $this->createMock(FlightRouter::class);
        // Expect the router to group routes under "/api"
        $flightRouterMock->expects($this->once())
            ->method('group')
            ->with(
                $this->equalTo('/api'),
                $this->isType('callable')
            );
        // Create an Engine mock that returns our router mock when router() is called.
        $engineMock = $this->getMockBuilder(Engine::class)
            ->addMethods(['router'])
            ->getMock();
        $engineMock->expects($this->once())
            ->method('router')
            ->willReturn($flightRouterMock);

        $authMiddlewareMock = $this->createMock(AuthMiddleware::class);
        $routerInstance = new Router($authMiddlewareMock);
        $routerInstance->buildRoutes($engineMock);
    }
}
