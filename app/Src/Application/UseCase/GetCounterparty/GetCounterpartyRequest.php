<?php

namespace Src\Application\UseCase\GetCounterparty;

class GetCounterpartyRequest
{
    public string $message_id;
    public function __construct(string $message_id)
    {
        $this->message_id = $message_id;
    }
}