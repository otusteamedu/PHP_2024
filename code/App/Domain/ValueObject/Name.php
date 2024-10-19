<?php

namespace App\Domain\ValueObject;

class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidName($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidName(string $value): void
    {
        if (mb_strlen($value) <= 3) {
            throw new \InvalidArgumentException('name must be at least 3 characters long');
        }
    }
}
