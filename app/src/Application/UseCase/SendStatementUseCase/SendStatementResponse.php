<?php

namespace App\Application\UseCase\SendStatementUseCase;

class SendStatementResponse
{
    public function __construct(
        public bool $result
    ) {
    }
}
