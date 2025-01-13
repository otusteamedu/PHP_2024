<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Amount;
use App\Domain\ValueObject\Description;
use App\Domain\ValueObject\AccountNumber;
use App\Domain\ValueObject\TransactionType;

class Transaction
{
    private ?int $id = null;
    private ?string $date = null;


    public function __construct(
        private readonly Amount $amount,
        private readonly Description $description,
        private readonly TransactionType $transactionType,
        private readonly AccountNumber $accountNumber
    ) {
    }

    public function getAccountNumber(): AccountNumber
    {
        return $this->accountNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }
}
