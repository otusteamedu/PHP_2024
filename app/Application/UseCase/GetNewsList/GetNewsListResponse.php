<?php

namespace App\Application\UseCase\GetNewsList;

class GetNewsListResponse
{
    public function __construct(
        public readonly array $newsList
    ) {
    }
}
