<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Domain\ValueObject;

class Amount
{
    public function __construct(public readonly float $amount)
    {
    }

    public function getValue(): float
    {
        return $this->amount;
    }
}
