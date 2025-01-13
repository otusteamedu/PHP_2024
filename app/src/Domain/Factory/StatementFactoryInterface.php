<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Statement;

interface StatementFactoryInterface
{
    public function create(
        int $accountNumber,
        string $dateFrom,
        string $dateTo,
        string $status
    ): Statement;
}
