<?php

namespace App\Application\UseCase\GetNews;

use App\Application\UseCase\GetNewsList\NewsForListDTO;

class GetNewsResponse
{
    public function __construct(
        public readonly NewsDTO $news,
    ) {
    }
}
