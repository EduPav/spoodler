<?php

namespace classes\api\legacy\control;

use classes\api\legacy\Request;

interface Handleable
{
    function handle(Request $request): array;
}
