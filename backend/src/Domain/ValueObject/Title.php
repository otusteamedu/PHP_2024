<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidTitle($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidTitle(string $value): void
    {
        if (mb_strlen($value) < 5) {
            throw new \InvalidArgumentException('Title must be at least 5 characters long');
        }
    }
}
