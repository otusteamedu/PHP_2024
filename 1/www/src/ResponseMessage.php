<?php

namespace Ahar\Hw4;

class ResponseMessage
{
    public function __construct(public readonly ResponseStatus $responseStatus, public readonly string $message)
    {
    }
}
