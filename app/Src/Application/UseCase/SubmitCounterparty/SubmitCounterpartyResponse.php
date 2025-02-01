<?php

namespace Src\Application\UseCase\SubmitCounterparty;

class SubmitCounterpartyResponse
{
    public string $id;
    public function __construct(
        string $id
    )
    {
        $this->id = $id;
    }
}