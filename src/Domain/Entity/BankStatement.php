<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Domain\Entity;

use Pozys\BankStatement\Domain\ValueObject\{Amount, Date};

class BankStatement
{
    public function __construct(private Date $date, private Amount $amount)
    {
    }
}
