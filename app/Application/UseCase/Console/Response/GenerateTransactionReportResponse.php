<?php

declare(strict_types=1);

namespace App\Application\UseCase\Console\Response;

final readonly class GenerateTransactionReportResponse
{
    public function __construct(
        public array $transactions,
    ) {
    }
}