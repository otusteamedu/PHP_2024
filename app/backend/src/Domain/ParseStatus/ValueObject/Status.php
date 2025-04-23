<?php

namespace AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject;

class Status
{
    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
