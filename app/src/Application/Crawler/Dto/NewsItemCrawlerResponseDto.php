<?php

declare(strict_types=1);

namespace App\Application\Crawler\Dto;

class NewsItemCrawlerResponseDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $url,
        public readonly \DateTimeImmutable $date,
    ) {
    }
}
