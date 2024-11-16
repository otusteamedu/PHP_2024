<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Account
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidAccount($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidAccount(string $value): void
    {
        if (mb_strlen($value) < 1) {
            throw new \InvalidArgumentException('Account must be at least 0 characters long');
        }
    }
}
