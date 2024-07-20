<?php

declare(strict_types=1);

namespace App\Application\UseCase\Console\Request;

class GenerateTransactionReportRequest
{
    public function __construct(
        public string $dateFrom,
        public string $dateTo,
        public string $accountFrom,
        public string $accountTo,
        public string $transactionType,
        public string $transactionStatus
    )
    {
    }
}