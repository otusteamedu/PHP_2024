<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Validator\UrlValidator;

readonly class Url
{
    private string $value;

    public function __construct(
        string $value
    )
    {
        UrlValidator::validate($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
