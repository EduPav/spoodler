<?php

namespace classes\advice;

use PHPUnit\Framework\TestCase;
use Monolog\Logger;
use classes\advice\OpenAIAdviceProvider;
use classes\api\exception\server\InternalServerErrorException;

class OpenAIAdviceProviderTest extends TestCase
{
    private $isAdviceEnabled;

    protected function setUp(): void
    {
        // Backup old config
        $this->isAdviceEnabled = $GLOBALS['config']['advice']['enabled'];
    }

    protected function tearDown(): void
    {
        $GLOBALS['config']['advice']['enabled'] = $this->isAdviceEnabled;
    }

    function testThrowsExceptionWhenAdviceDisabled(): void
    {
        $GLOBALS['config']['advice']['enabled'] = false;
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage('AI Advices are disabled.');
        $logger = $this->createMock(Logger::class);
        new OpenAIAdviceProvider($logger);
    }
}
