<?php

namespace App\Application\UseCase\ListNews;

use App\Domain\Entity\News;

class ListNewsResponse
{
    public function __construct(
        public string $name,
        public string $url,
        public string $created_at,
    )
    {
    }
}
