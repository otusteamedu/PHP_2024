<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\BankStatement;

interface BankStatementRepositoryInterface
{
    public function save(BankStatement $bankStatement): void;

    public function findInRange(int $account, \DateTime $dateFrom, \DateTime $dateTo): ?array;
}
