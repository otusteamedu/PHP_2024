<?php

namespace App\Application\UseCase\GetStatementUseCase;

class GetStatementRequest
{
    public function __construct(
        public int $statementId
    )
    {
    }

}