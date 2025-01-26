<?php

namespace classes\api\legacy\render;

use classes\api\legacy\ApiResponse;

interface Renderable
{
    function renderSuccess(ApiResponse $response): string;
    function renderNotFound(ApiResponse $response): string;
    function renderError(ApiResponse $response): string;
}
