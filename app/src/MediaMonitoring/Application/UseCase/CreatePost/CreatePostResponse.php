<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

final readonly class CreatePostResponse
{
    public function __construct(
        public int $postId,
    ) {}
}
