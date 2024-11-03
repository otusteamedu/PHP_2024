<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

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

    private function assertValidUrl(string $value): void
    {
        if (mb_strlen($value) < 1) {
            throw new Exception('Invalid url');
        }
    }
}
