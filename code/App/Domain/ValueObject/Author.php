<?php

namespace App\Domain\ValueObject;

class Author
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidAuthor($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidAuthor(string $value): void
    {
        if (mb_strlen($value) <= 3) {
            throw new \InvalidArgumentException('Author must be at least 3 characters long');
        }
    }
}
