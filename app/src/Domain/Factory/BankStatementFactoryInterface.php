<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\BankStatement;

interface BankStatementFactoryInterface
{
    public function create(string $account, string $dateFrom, string $dateTo): BankStatement;
}
