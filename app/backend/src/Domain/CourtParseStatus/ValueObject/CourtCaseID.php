<?php

namespace AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject;

class CourtCaseID
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
