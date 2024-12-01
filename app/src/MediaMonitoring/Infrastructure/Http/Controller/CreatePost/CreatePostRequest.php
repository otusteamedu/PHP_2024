<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\CreatePost;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreatePostRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Url]
        public string $url,
    ) {}
}
