<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class GetStatementInRangeUseCaseRequest
{
    public function __construct(
        public int    $account,
        public string $dateFrom,
        public string $dateTo,
    )
    {
    }
}