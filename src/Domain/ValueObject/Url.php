<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidUrl($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }
    }
}
