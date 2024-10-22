<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

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
}
