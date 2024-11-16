<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Email
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
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email.');
        }
    }
}
