<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsList;

class NewsListItem
{
    public function __construct(
        public int $id,
        public string $title,
        public string $url,
        public string $exportDate
    ) {
    }
}
