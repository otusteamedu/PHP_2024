<?php

namespace Src\Application\UseCase\SetStatement;

class SetStatementRequest
{
    public int $user_id;
    public string $from_date;
    public string $to_date;
    public function __construct(
        int $user_id,
        string $from_date,
        string $to_date
    )
    {
        $this->user_id = $user_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
}