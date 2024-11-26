<?php

namespace App\Domain\ValueObjects;

class Name
{
    private string $name;

    public function __construct($value)
    {
        $this->assertName($value);
        $this->name = $value;
    }

    private function assertName($value): void
    {
        if (!is_string($value)) {
            throw new \Exception(sprintf('name: expected string, got %s', gettype($value)));
        }

        if (empty($value)) {
            throw new \Exception('name: expected not empty string');
        }
    }

    public function getValue(): string
    {
        return $this->name;
    }
}