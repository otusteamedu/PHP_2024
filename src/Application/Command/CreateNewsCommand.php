<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Uuid;

readonly class CreateNewsCommand
{
    public function __construct(
        public Uuid $uuid,
        public string $url
    ) {}

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
