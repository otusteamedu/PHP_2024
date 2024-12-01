<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\ListPosts;

final readonly class PostListItem
{
    public function __construct(
        public int $id,
        public string $title,
        public string $date,
        public string $url,
    ) {}
}
