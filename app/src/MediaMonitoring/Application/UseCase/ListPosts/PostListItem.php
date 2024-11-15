<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\ListPosts;

use App\MediaMonitoring\Domain\Entity\PostId;
use App\MediaMonitoring\Domain\Entity\PostTitle;
use App\MediaMonitoring\Domain\Entity\PostUrl;
use DateTimeInterface;

final readonly class PostListItem
{
    public function __construct(
        public PostId $id,
        public PostTitle $title,
        public DateTimeInterface $date,
        public PostUrl $url,
    ) {}
}
