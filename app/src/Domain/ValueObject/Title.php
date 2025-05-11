<?php

namespace Anatolyshilyaev\Hw14\Domain\ValueObject;

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

    public function assertValidTitle(string $value): void
    {
        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException("Title must be less thab 255 characters long");
        }
    }
}
