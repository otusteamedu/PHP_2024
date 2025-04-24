<?php

namespace AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject;

class ErrorType
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
