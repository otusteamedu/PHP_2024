<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Dto;

final readonly class NewsDto
{
    public function __construct(
        public string $url,
        public string $title
    ) {
    }
}
