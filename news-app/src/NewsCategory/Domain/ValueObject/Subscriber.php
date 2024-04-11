<?php

declare(strict_types=1);

namespace App\NewsCategory\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

abstract readonly class Subscriber
{
    public function __construct(
        private readonly StringValue $value
    )
    {
    }

    abstract public function getType(): StringValue;

    public function getValue(): StringValue
    {
        return $this->value;
    }
}