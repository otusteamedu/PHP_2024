<?php

namespace App\Application\UseCase\GetNewsList;

class GetNewsListResponse
{
    /**
     * @param NewsDTO[] $newsList
     */
    public function __construct(
        public readonly array $newsList
    ) {
    }
}
