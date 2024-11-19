<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class SubmitStatementRequest
{
    public function __construct(public readonly string $account, public readonly string $dateFrom, public readonly string $dateTo)
    {
    }
}
