<?php

namespace classes\api\legacy\render;

use classes\api\legacy\ApiResponse;
use classes\api\legacy\render\Renderable;
use classes\api\Header;

class Json implements Renderable
{

    function __construct(Header $header)
    {
        $header->set(Header::JSON_CONTENT);
    }

    function renderSuccess(ApiResponse $response): string
    {
        return $this->genericRender($response);
    }

    function renderError(ApiResponse $response): string
    {
        return $this->genericRender($response);
    }

    function renderNotFound(ApiResponse $response): string
    {
        return $this->genericRender($response);
    }

    private function genericRender(ApiResponse $response): string
    {
        return json_encode([
            "message" => $response->getMessage(),
            "data" => $response->getData()
        ]);
    }
}
