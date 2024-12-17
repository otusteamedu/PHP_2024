<?php

namespace App\Domain\ValueObject;
class Size
{
    private string $value;

    public function __construct(?int $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }


}