<?php

namespace App\Domain\ValueObject;

class Text
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidText($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidText(string $value): void
    {
        if (mb_strlen($value) <= 3) {
            throw new \InvalidArgumentException('Text must be at least 3 characters long');
        }
    }
}
