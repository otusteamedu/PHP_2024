<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class HolderEmail
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidEmail($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidEmail(string $value): void
    {
        if (mb_strlen($value) < 3) {
            throw new \InvalidArgumentException('Name must be at least 3 characters long');
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email address '$value' is not valid.");
        }
    }
}
