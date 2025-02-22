<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Id
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValidTitle($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    private function assertValidTitle(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Id must be greater than 0');
        }
    }
}
