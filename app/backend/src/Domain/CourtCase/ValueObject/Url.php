<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject;

class Url
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        if ($value !== null) {
            $this->assertValidTitle($value);
        }
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function assertValidTitle(?string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Wrong URL format");
        }
    }
}
