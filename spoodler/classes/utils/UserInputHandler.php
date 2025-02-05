<?php

namespace classes\utils;

use classes\api\exception\client\BadRequestException;
use classes\api\exception\server\InternalServerErrorException;

class UserInputHandler
{
    /**
     * Sanitize input to remove harmful characters.
     * @param string $input The user input to sanitize.
     * @return string Sanitized input.
     */
    function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Assert that the input is an integer.
     * Throws BadRequestException if the input is not an integer.
     * @param mixed $input The input to validate.
     * @param string $keyName The name of the key being validated.
     * @throws BadRequestException If validation fails.
     */
    function assertInt(mixed $input, string $keyName): void
    {
        if (filter_var($input, FILTER_VALIDATE_INT) === false) {
            throw new BadRequestException("$keyName must be an integer: $keyName='$input'");
        }
    }

    /**
     * Validate input against specific rules.
     * Throws BadRequestException if validation fails.
     * @param string $input The input to validate.
     * @param string $keyName The name of the key being validated.
     * @param string $type The validation type (e.g. 'integer').
     * @return mixed The validated and possibly converted value.
     * @throws BadRequestException If validation fails.
     */
    function validate(string $input, string $keyName, string $type): mixed
    {
        switch ($type) {
            case 'integer':
                $this->assertInt($input, $keyName);
                $convertedValue = (int) $input;
                return $convertedValue;

            default:
                throw new InternalServerErrorException("Unsupported validation type: $type");
        }
    }

    /**
     * Check if a key exists in an array.
     * Throws BadRequestException if the key is missing.
     * @param array $array The array to check.
     * @param string $key The key to look for.
     * @return mixed The value associated with the key.
     * @throws BadRequestException If the key is missing.
     */
    function requireKey(array $array, string $key): mixed
    {
        if (!array_key_exists($key, $array) || $array[$key] === null) {
            throw new BadRequestException("Parameter '$key' is required.");
        }
        return $array[$key];
    }

    /**
     * Require, sanitize, and validate a key in an array.
     * Throws BadRequestException if the key is missing or validation fails.
     * @param array $array The input array.
     * @param string $key The key to check.
     * @param string $type The validation type (e.g. 'integer').
     * @return mixed The sanitized and validated value.
     * @throws BadRequestException If the key is missing or validation fails.
     */
    function requireSanitizeValidate(array $array, string $key, string $type): mixed
    {
        $value = $this->requireKey($array, $key);
        $sanitizedValue = $this->sanitize($value);
        return $this->validate($sanitizedValue, $key, $type);
    }
}
