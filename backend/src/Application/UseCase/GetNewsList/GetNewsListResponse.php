<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNewsList;

readonly class GetNewsListResponse
{
    public function __construct(
        public int $id,
        public string $date,
        public string $url,
        public string $title,
    ) {
    }
}
