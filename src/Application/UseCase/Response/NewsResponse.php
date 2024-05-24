<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class NewsResponse
{
    public function __construct(
        public int    $id,
        public string $url,
        public string $title,
        public string $createdDate
    ) {}
}