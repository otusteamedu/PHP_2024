<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Date
{
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->value;
    }
}
