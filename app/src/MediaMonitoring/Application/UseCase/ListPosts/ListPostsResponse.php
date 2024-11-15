<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\ListPosts;

final readonly class ListPostsResponse
{
    public array $items;

    public function __construct(
        PostListItem ...$items,
    ) {
        $this->items = $items;
    }
}
