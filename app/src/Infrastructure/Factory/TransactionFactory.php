<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Transaction;
use App\Domain\Factory\TransactionFactoryInterface;
use App\Domain\ValueObject\AccountNumber;
use App\Domain\ValueObject\Amount;
use App\Domain\ValueObject\Description;
use App\Domain\ValueObject\TransactionType;

class TransactionFactory implements TransactionFactoryInterface
{
    public function create(int $amount, string $description, int $transactionType, int $accountNumber): Transaction
    {
        return new Transaction(
            new Amount($amount),
            new Description($description),
            new TransactionType($transactionType),
            new AccountNumber($accountNumber)
        );
    }
}
