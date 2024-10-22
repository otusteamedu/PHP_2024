<?php

declare(strict_types=1);

namespace App\Application\Bus\Dto;

class NewsItemUrlBusResponseDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $url,
        public readonly \DateTime $date,
    ) {
    }
}
