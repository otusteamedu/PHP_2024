<?php

namespace Src\Domain\ValueObject;

class Inn
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidInn($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidInn(string $value): void
    {
        if (mb_strlen($value) !== 10 || mb_strlen($value) !== 12) {
            throw new \InvalidArgumentException('Inn must be at least 3 characters long');
        }
    }
}
