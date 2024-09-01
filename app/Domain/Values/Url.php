<?php

namespace App\Domain\Values;

use InvalidArgumentException;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $url = filter_var($value, FILTER_VALIDATE_URL);

        $this->assertValidValue($url);

        $this->value = $url;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidValue(string|false $url): void
    {
        if ($url === false) {
            throw new InvalidArgumentException('Invalid url.');
        }
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
