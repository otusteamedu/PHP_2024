<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\DTO;

class ListNewsResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $date,
        public readonly string $title,
        public readonly string $url,
    ) {
    }
}
