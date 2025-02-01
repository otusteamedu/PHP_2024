<?php

namespace Src\Application\UseCase\SubmitCounterparty;

class SubmitCounterpartyRequest
{
    public int $userId;
    public string $inn;
    public function __construct(
        int $userId,
        string $inn
    )
    {
        $this->userId = $userId;
        $this->inn = $inn;
    }
}