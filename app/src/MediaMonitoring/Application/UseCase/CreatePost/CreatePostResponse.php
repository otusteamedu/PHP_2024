<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

use App\MediaMonitoring\Domain\Entity\PostId;

final readonly class CreatePostResponse
{
    public function __construct(
        public PostId $postId,
    ) {}
}
