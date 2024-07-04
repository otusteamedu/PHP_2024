<?php

namespace App\Domain\Entity;


use App\Domain\ValueObject\Dates;

class StatementRequest
{

    private string $statementRequest;

    public function __construct(
        Dates $interval
    ) {
        $this->statementRequest = $interval->get();
    }

    public function get(): string
    {
        return $this->statementRequest;
    }


}