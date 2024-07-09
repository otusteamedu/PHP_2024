<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class ApiRequestBody
{
    public function __construct(private string $body)
    {
    }

    public function getValue(): string
    {
        return $this->body;
    }
}
