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
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid author: ' . $value);
        }
    }
}
