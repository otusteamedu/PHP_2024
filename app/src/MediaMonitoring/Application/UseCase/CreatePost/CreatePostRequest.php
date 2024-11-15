<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

use App\MediaMonitoring\Domain\Entity\PostUrl;

final readonly class CreatePostRequest
{
    public function __construct(
        public PostUrl $url,
    ) {}
}
