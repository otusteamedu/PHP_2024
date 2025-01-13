<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Transaction;

interface TransactionFactoryInterface
{
    public function create(
        int $amount,
        string $description,
        int $transactionType,
        int $accountNumber
    ): Transaction;
}
