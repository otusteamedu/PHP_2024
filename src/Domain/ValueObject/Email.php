<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(
        string $value
    ) {
        $this->setValue($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function setValue(string $value): void
    {
        $this->assertLength($value);
        $this->assertEmail($value);
        $this->value = $value;
    }

    private function assertLength(string $value): void
    {
        if (strlen($value) > 60) {
            throw new InvalidArgumentException('Длина email пользователя не должна превышать 60 символов');
        }
    }
    private function assertEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректный email');
        }
    }
}
