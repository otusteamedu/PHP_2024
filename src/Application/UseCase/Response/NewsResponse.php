<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class NewsResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly string $title,
        public readonly string $createdDate
    ) {}
}