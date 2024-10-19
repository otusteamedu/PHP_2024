<?php

namespace App\Domain\ValueObject;

class Param
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValidParam($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
    private function assertValidParam(int $value): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('priority must be a positive number');
        }
    }

}
