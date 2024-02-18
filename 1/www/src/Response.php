<?php

namespace Ahar\Hw4;

class Response
{
    public function send(ResponseMessage $responseMessage): void
    {
        http_response_code($responseMessage->responseStatus->value);
        echo $responseMessage->message;
    }
}
