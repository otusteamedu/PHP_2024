<?php

namespace App\Application\UseCase\SendStatementUseCase;



use App\Domain\Entity\Statement;

class SendStatementResponse
{
    public function __construct(
        public bool $result
    )
    {
    }

}