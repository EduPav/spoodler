<?php

namespace classes\advice;

class AdviceService
{
    private $provider;

    function __construct(AdviceProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    function getAdviceForError(array $errorReport): string
    {
        return $this->provider->getAdvice($errorReport);
    }
}
