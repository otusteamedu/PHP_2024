<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Entity;

use DateTime;

class BankStatement
{
    private int $id;
    public function __construct(
        private string $clientName,
        private string $accountNumber,
        private DateTime $startDate,
        private DateTime $endDate,
        private string $statementFileName,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatementFileName(): string
    {
        return $this->statementFileName;
    }

    public function setStatementFileName(string $statementFileName): self
    {
        $this->statementFileName = $statementFileName;

        return $this;
    }
}
