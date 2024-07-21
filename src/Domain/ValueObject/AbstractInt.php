<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

abstract class AbstractInt
{
    public function __construct(private readonly int $value)
    {
    }
    public function getValue(): int
    {
        return $this->value;
    }
    public function __toString(): string
    {
        return  strval($this->value);
    }
}
