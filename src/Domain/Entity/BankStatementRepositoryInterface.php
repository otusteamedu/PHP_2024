<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Domain\Entity;

use Pozys\BankStatement\Domain\ValueObject\Date;

interface BankStatementRepositoryInterface
{
    public function forPeriod(Date $from, Date $to): array;
}
