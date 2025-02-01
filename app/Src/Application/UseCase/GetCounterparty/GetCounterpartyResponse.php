<?php

namespace Src\Application\UseCase\GetCounterparty;

class GetCounterpartyResponse
{
    public int $status_id;
    public ?array $result;
    public function __construct(
        int $status_id, array $result
    )
    {
        $this->status_id = $status_id;
        $this->result = $result;
    }
}