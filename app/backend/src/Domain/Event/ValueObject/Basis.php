<?php

namespace AnatolyShilyaev\Backend\Domain\Event\ValueObject;

class Basis
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
