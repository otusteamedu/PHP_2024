<?php

namespace AnatolyShilyaev\Backend\Domain\CourtCase\ValueObject;

use DateTimeImmutable;

class RegisterDate
{
    private ?DateTimeImmutable $value;

    public function __construct(?DateTimeImmutable $value = null)
    {
        $this->value = $value;
    }

    public function getValue(): ?DateTimeImmutable
    {
        return $this->value;
    }
}
