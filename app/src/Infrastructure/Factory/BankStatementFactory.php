<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Factory\BankStatementFactoryInterface;
use App\Domain\Entity\BankStatement;
use App\Domain\ValueObject\Account;
use App\Domain\ValueObject\Date;

class BankStatementFactory implements BankStatementFactoryInterface
{
    public function create(string $account, string $dateFrom, string $dateTo): BankStatement
    {
        return new BankStatement(
            new Account($account),
            new Date($dateFrom),
            new Date($dateTo)
        );
    }
}
