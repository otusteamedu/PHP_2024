<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Entity\BankStatement;
use App\Domain\Factory\BankStatementFactoryInterface;
use App\Domain\ValueObject\Account;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;

class BankStatementFactory implements BankStatementFactoryInterface
{
    public function create(int $account, string $title, string $date): BankStatement
    {
        return new BankStatement(
            (new Account($account))->getValue(),
            (new Title($title))->getValue(),
            (new Date($date))->getValue()
        );
    }
}
