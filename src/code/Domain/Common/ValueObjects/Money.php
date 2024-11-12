<?php

declare(strict_types=1);

namespace Domain\Common\ValueObjects;

class Money extends DecimalValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
