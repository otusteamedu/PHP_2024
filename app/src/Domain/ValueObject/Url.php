<?php

namespace AnatolyShilyaev\Hw15\Domain\ValueObject;

class Url
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

    public function assertValidTitle(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Wrong URL format");
        }
    }
}
