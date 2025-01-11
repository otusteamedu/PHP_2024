<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\AccountNumber;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\DateTime;
use App\Domain\ValueObject\Status;

class Statement
{
    private ?int $id = null;
    public function __construct(
        private AccountNumber $account,
        private Date $dateFrom,
        private Date $dateTo,
        private Status $status,
        private iterable $transactions = []
    )
    {
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function setTransactions(array $transactions): void
    {
        $this->transactions = $transactions;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getDateFrom(): Date
    {
        return $this->dateFrom;
    }

    public function getDateTo(): Date
    {
        return $this->dateTo;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): AccountNumber
    {
        return $this->account;
    }

    public function getAccountId()
    {
    }

}