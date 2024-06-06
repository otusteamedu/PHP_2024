<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Domain\ValueObject;

class Date
{
    public function __construct(public readonly string $date)
    {
    }

    public function getValue(): string
    {
        return $this->date;
    }
}
