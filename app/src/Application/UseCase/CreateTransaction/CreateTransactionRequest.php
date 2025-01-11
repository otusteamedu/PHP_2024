<?php

namespace App\Application\UseCase\CreateTransaction;

class CreateTransactionRequest
{
    public function __construct(
        public int $amount,
        public string $description,
        public int $transactionType,
        public int $accountId
    )
    {
    }

}