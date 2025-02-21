<?php

namespace classes\utils;

use PHPUnit\Framework\TestCase;
use classes\api\exception\client\BadRequestException;
use classes\api\exception\server\InternalServerErrorException;
use classes\utils\UserInputHandler;

class UserInputHandlerTest extends TestCase
{
    private $handler;

    protected function setUp(): void
    {
        $this->handler = new UserInputHandler();
    }

    function testSanitize(): void
    {
        $input = " <script>alert('hack');</script> ";
        $expected = "&lt;script&gt;alert(&#039;hack&#039;);&lt;/script&gt;";
        $this->assertEquals($expected, $this->handler->sanitize($input));
    }

    function testValidateIntegerSuccess(): void
    {
        $input = "123";
        $result = $this->handler->validate($input, 'input', 'integer');
        $this->assertEquals(123, $result);
        $this->assertIsInt($result);
    }

    function testValidateIntegerFailure(): void
    {
        $input = "abc";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("input must be an integer: input='abc'");
        $this->handler->validate($input, 'input', 'integer');
    }

    function testValidateUnsupportedType(): void
    {
        $input = "test";
        $type = "weird";
        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Unsupported validation type: weird");
        $this->handler->validate($input, 'input', $type);
    }

    function testRequireKeySuccess(): void
    {
        $array = ['key' => 'value'];
        $this->assertEquals('value', $this->handler->requireKey($array, 'key'));
    }

    function testRequireKeyMissingKey(): void
    {
        $array = ['key' => 'value'];
        $missingKey = 'missingKey';

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Parameter 'missingKey' is required.");
        $this->handler->requireKey($array, $missingKey);
    }

    function testRequireKeyEmptyKey(): void
    {
        $array = ['key' => null];

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Parameter 'key' is required.");
        $this->handler->requireKey($array, 'key');
    }

    function testRequireSanitizeValidateSuccess(): void
    {
        $array = ['key' => ' 123 '];
        $result = $this->handler->requireSanitizeValidate($array, 'key', 'integer');
        $this->assertEquals(123, $result);
        $this->assertIsInt($result); // Ensures the value is an integer
    }

    function testRequireSanitizeValidateMissingKey(): void
    {
        $array = ['key' => '123'];
        $missingKey = 'missingKey';

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Parameter 'missingKey' is required.");
        $this->handler->requireSanitizeValidate($array, $missingKey, 'integer');
    }

    function testRequireSanitizeValidateInvalidValue(): void
    {
        $array = ['key' => 'not-an-integer'];

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("key must be an integer: key='not-an-integer'");
        $this->handler->requireSanitizeValidate($array, 'key', 'integer');
    }

    function testRequireSanitizeValidateUnsupportedType(): void
    {
        $array = ['key' => '123'];
        $unsupportedType = 'unsupported';

        $this->expectException(InternalServerErrorException::class);
        $this->expectExceptionMessage("Unsupported validation type: $unsupportedType");
        $this->handler->requireSanitizeValidate($array, 'key', $unsupportedType);
    }

    function testAssertIntValidString(): void
    {
        $input = "100";
        // Should pass without throwing an exception.
        $this->handler->assertInt($input, 'input');
        $this->addToAssertionCount(1);
    }

    function testAssertIntValidInteger(): void
    {
        $input = 200;
        // Integers are integers—even when they don't wear quotes.
        $this->handler->assertInt($input, 'input');
        $this->addToAssertionCount(1);
    }

    function testAssertIntFailureWithAlphabeticString(): void
    {
        $input = "abc";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("input must be an integer: input='abc'");
        $this->handler->assertInt($input, 'input');
    }

    function testAssertIntFailureWithFloatString(): void
    {
        $input = "12.3";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("input must be an integer: input='12.3'");
        $this->handler->assertInt($input, 'input');
    }

    function testAssertEmailValid(): void
    {
        $input = "test@example.com";
        $this->handler->assertEmail($input, 'email');
        $this->addToAssertionCount(1);
    }

    function testAssertEmailInvalid(): void
    {
        $input = "invalid-email";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("email must be a valid email address: email='invalid-email'");
        $this->handler->assertEmail($input, 'email');
    }

    function testValidateEmailSuccess(): void
    {
        $input = "test@example.com";
        $result = $this->handler->validate($input, 'email', 'email');
        $this->assertEquals("test@example.com", $result);
    }

    function testValidateEmailFailure(): void
    {
        $input = "not-an-email";
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("email must be a valid email address: email='not-an-email'");
        $this->handler->validate($input, 'email', 'email');
    }

    function testValidateString(): void
    {
        $input = "hello world";
        $result = $this->handler->validate($input, 'text', 'string');
        $this->assertEquals("hello world", $result);
    }
}
