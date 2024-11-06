<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

final readonly class CreatePostRequest
{
    public function __construct(
        public string $url,
    ) {}
}
