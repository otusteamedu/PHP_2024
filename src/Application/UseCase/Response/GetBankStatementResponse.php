<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Response;

readonly class GetBankStatementResponse implements JsonResponseInterface
{
    public function __construct(
        public int $id,
        public string $clientName,
        public string $accountNumber,
        public string $startDate,
        public string $endDate,
        public string $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'clientName' => $this->clientName,
            'accountNumber' => $this->accountNumber,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'status' => $this->status,
        ];
    }
}
