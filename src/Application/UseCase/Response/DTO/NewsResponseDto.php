<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response\DTO;

readonly class NewsResponseDto
{
    public function __construct(
        public int $id,
        public string $date,
        public string $url,
        public string $title,
    ) {
    }
}
