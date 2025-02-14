<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Account
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertIsAccount($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    private function assertIsAccount(int $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Неверный аккаунт');
        }
    }
}