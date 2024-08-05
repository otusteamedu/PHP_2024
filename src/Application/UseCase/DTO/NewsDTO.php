<?php

declare(strict_types=1);

namespace App\Application\UseCase\DTO;

readonly class NewsDTO
{
    public function __construct(
        public int $id,
        public string $url,
        public string $title,
        public string $date
    ) {
    }
}
