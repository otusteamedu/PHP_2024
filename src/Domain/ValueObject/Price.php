<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Price
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return strval($this->value);
    }
}
