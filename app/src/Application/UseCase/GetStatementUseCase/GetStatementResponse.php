<?php

namespace App\Application\UseCase\GetStatementUseCase;



use App\Domain\Entity\Statement;

class GetStatementResponse
{
    public function __construct(
        public Statement $statement
    ) {
    }
}
