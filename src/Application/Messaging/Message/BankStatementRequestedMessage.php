<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\Message;

readonly class BankStatementRequestedMessage implements QueueMessageInterface
{
    public function __construct(
        private string $clientName,
        private string $accountNumber,
        private string $startDate,
        private string $endDate,
    ) {
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function toArray(): array
    {
        return [
            'clientName' => $this->clientName,
            'accountNumber' => $this->accountNumber,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}
