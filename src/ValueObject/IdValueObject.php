<?php

declare(strict_types=1);

namespace App\ValueObject;

use Ramsey\Uuid\Uuid;

readonly class IdValueObject
{
    public function __construct(public string $value)
    {
    }

    public static function generate(): IdValueObject
    {
        return new self(Uuid::uuid4()->toString());
    }
}
