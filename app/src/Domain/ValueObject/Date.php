<?php

namespace Anatolyshilyaev\Hw14\Domain\ValueObject;

use DateTimeImmutable;

class Date
{
    private DateTimeImmutable $value;

    public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
