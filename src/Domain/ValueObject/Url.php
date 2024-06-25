<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Url
{
    private string $value;

    public function __construct(
        string $value
    ) {
        $this->assertUrl($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertUrl(string $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Передан не валидный Url');
        }
    }
}
