<?php

namespace classes\api\legacy\render;

use classes\api\legacy\render\Renderable;
use classes\api\legacy\ApiResponse;
use classes\api\Header;

class Text implements Renderable
{

    function __construct(Header $header)
    {
        $header->set(Header::TEXT_CONTENT);
    }

    function renderSuccess(ApiResponse $response): string
    {
        return join("\n", $response->getData());
    }

    function renderError(ApiResponse $response): string
    {
        return $response->getMessage();
    }

    function renderNotFound(ApiResponse $response): string
    {
        return $response->getMessage();
    }
}
