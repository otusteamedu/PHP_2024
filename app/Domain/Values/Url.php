<?php

namespace App\Domain\Values;

use InvalidArgumentException;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidValue($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidValue(string $value): void
    {
        $url = filter_var($value, FILTER_VALIDATE_URL);

        if ($url === false) {
            throw new InvalidArgumentException('Invalid url.');
        }
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
