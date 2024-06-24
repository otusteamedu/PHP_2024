<?php

declare(strict_types=1);

namespace App\ValueObject;

readonly class DataValueObject
{
    public function __construct(public array $value)
    {
    }
}
