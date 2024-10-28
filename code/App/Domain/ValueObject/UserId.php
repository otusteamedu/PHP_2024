<?php

namespace App\Domain\ValueObject;

class UserId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValidUserId($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidUserId(int $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('User id is not valid');
        }
    }
}
