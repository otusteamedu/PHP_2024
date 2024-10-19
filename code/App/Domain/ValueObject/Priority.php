<?php

namespace App\Domain\ValueObject;

class Priority
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValidPriority($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    private function assertValidPriority(int $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('priority must be a positive number');
        }
    }
}
