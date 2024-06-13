<?php

declare(strict_types=1);

namespace App\Application\Command;

class CreateNewsCommand
{
    public function __construct(
        public readonly string $url
    ) {}

    public function getUrl(): string
    {
        return $this->url;
    }
}
