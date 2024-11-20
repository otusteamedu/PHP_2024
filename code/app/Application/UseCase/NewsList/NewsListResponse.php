<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsList;

class NewsListResponse
{
    /**
     * @param NewsListItem[] $newsList
     */
    public function __construct(
        public iterable $newsList
    ) {
    }
}
