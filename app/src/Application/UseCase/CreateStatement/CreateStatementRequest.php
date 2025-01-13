<?php

namespace App\Application\UseCase\CreateStatement;

class CreateStatementRequest
{
    public function __construct(
        public int $accountNumber,
        public string $dateFrom,
        public string $dateTo,
        public string $status = 'REQUESTED'
    ) {
    }
}
