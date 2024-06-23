<?php

namespace Ahor\Hw19\response;

readonly class ResponseMessage
{
    public function __construct(public ResponseStatus $responseStatus, public string $message)
    {
    }
}
