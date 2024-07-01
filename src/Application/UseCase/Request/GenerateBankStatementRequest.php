<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Request;

readonly class GenerateBankStatementRequest
{
    public function __construct(
        public string $clientName,
        public string $accountNumber,
        public string $startDate,
        public string $endDate,
    ) {
    }
}
