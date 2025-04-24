<?php

namespace AnatolyShilyaev\Backend\Domain\Event\ValueObject;

use DateTimeImmutable;

class ResultDate
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
