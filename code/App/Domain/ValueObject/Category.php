<?php

namespace App\Domain\ValueObject;

class Category
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidCategory($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidCategory(string $value): void
    {
        if (mb_strlen($value) <= 3) {
            throw new \InvalidArgumentException('Name must be at least 3 characters long');
        }
    }
}
