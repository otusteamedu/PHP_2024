<?php

namespace App\Domain\ValueObject;

class Body
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidBody($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidBody(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid body: ' . $value);
        }
    }

}
