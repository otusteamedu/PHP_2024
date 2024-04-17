<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertTitleIsValid($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertTitleIsValid(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException(
                "Заголовок не может быть пустым"
            );
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
