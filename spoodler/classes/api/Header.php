<?php

namespace classes\api;

class Header
{
    // Predefined constants for common headers
    public const JSON_CONTENT = 'Content-Type: application/json';
    public const HTML_CONTENT = 'Content-Type: text/html';
    public const TEXT_CONTENT = 'Content-Type: text/plain';

    /**
     * Sets the header value.
     *
     * @param string $header
     * @return void
     */
    public function set(string $header): void
    {
        header($header);
    }
}
