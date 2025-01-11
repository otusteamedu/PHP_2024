<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Statement;

use App\Domain\Factory\StatementFactoryInterface;
use App\Domain\ValueObject\AccountNumber;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Status;


class StatementFactory implements StatementFactoryInterface
{

    public function create(int $accountNumber, string $dateFrom, string $dateTo, string $status): Statement
    {
        return new Statement(
            new AccountNumber ($accountNumber),
            new Date ($dateFrom),
            new Date ($dateTo),
            new Status ($status)
        );

    }
}