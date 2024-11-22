<?php

namespace App\Application\UseCase\News\GetAllNews;

class GetAllNewsUseCaseResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $createdAt,
        public readonly string $urlValue,
        public readonly string $title
    ) {
    }
}
