<?php

namespace App\Domain\ValueObject;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidTitle($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidTitle(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid title: ' . $value);
        }
    }

}
