<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Messaging\Message;

readonly class BankStatementRequestedMessage implements QueueMessageInterface
{
    public function __construct(
        public string $clientName,
        public string $accountNumber,
        public string $startDate,
        public string $endDate,
    ) {
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
