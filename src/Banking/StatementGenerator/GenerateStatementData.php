<?php

declare(strict_types=1);

namespace App\Banking\StatementGenerator;

final readonly class GenerateStatementData
{
    public function __construct(
        public int $userId,
        public \DateTimeImmutable $dateFrom,
        public \DateTimeImmutable $dateTo,
    ) {}

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ];
    }
}
