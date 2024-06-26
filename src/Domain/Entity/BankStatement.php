<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Entity;

use Alogachev\Homework\Domain\ValueObject\BankStatementStatus;
use DateTime;

class BankStatement
{
    private int $id;
    public function __construct(
        private string $clientName,
        private string $accountNumber,
        private DateTime $startDate,
        private DateTime $endDate,
        private ?string $statementFileName,
        private BankStatementStatus $status,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatementFileName(): ?string
    {
        return $this->statementFileName;
    }

    public function setStatementFileName(?string $statementFileName): self
    {
        $this->statementFileName = $statementFileName;

        return $this;
    }

    public function getStatus(): BankStatementStatus
    {
        return $this->status;
    }

    public function setStatus(BankStatementStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
