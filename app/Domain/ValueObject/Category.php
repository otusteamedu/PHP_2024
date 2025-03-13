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
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid category: ' . $value);
        }
    }
}
