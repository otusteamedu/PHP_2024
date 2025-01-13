<?php

namespace App\Application\UseCase\SendStatementUseCase;

use App\Domain\Entity\Statement;

class SendStatementRequest
{
    public function __construct(
        public Statement $statement
    ) {
    }
}
