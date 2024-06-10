<?php

declare(strict_types=1);

namespace App\Application\Queue\Request;

use App\Domain\Entity\News;

class QueueRequest
{
    public function __construct(
        public readonly int $newsId
    ) {} // phpcs:ignore
}
