<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\ValueObject;

class Date
{
    private \DateTime $value;

    public function __construct(\DateTime $value)
    {
        $this->value = $value;
    }

    public function getValue(): \DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d');
    }
}
