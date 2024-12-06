<?php

declare(strict_types=1);

namespace App\Application\Crawler\Dto;

class NewsItemCrawlerRequestDto
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
