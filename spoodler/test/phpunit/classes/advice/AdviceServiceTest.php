<?php

namespace classes\advice;

use PHPUnit\Framework\TestCase;
use classes\advice\AdviceService;
use classes\advice\AdviceProviderInterface;

class AdviceServiceTest extends TestCase
{
    function testGetAdviceForErrorReturnsExpectedAdvice()
    {
        $errorReport = ['error' => 'Something went wrong'];
        $expectedAdvice = 'Try turning it off and on again.';

        $providerMock = $this->createMock(AdviceProviderInterface::class);
        $providerMock->expects($this->once())
            ->method('getAdvice')
            ->with($errorReport)
            ->willReturn($expectedAdvice);

        $adviceService = new AdviceService($providerMock);
        $actualAdvice = $adviceService->getAdviceForError($errorReport);

        $this->assertEquals($expectedAdvice, $actualAdvice);
    }
}
