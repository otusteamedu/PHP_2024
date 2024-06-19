<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Persistence;

use Pozys\BankStatement\Domain\Entity\BankStatementRepositoryInterface;
use Pozys\BankStatement\Domain\ValueObject\Date;

class BankStatementRepository implements BankStatementRepositoryInterface
{
    public function forPeriod(Date $from, Date $to): array
    {
        return [
            [
                'date' => $from->getValue(),
                'amount' => 1000
            ],
            [
                'date' => $to->getValue(),
                'amount' => 2000
            ]
        ];
    }
}
