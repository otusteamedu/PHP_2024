<?php

declare(strict_types=1);

namespace App\Http;

readonly class Response
{
    public function __construct(private string $content)
    {
    }

    public function __toString(): string
    {
        return $this->content;
    }
}