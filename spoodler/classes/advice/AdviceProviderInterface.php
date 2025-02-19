<?php

namespace classes\advice;

interface AdviceProviderInterface
{
    function getAdvice(array $errorReport): string;
}
