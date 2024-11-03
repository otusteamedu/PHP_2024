<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNewsList;

class GetNewsListResponse
{
    public function __construct(
        public iterable $newsList
    ) {
    }
}
