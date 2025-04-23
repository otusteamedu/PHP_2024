<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject;

class CaseNumber
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
