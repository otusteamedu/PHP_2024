<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Dates;

class StatementRequest
{

    private Dates $statementRequest;

    public function __construct(
        Dates $interval
    ) {
        $this->statementRequest = $interval;
    }

    public function getStatementRequest(): Dates
    {
        return $this->statementRequest;
    }


}