<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Messages;

class NewsMessage
{
    public function __construct(
        private readonly int $newsId
    ) {} // phpcs:ignore

    public function getNewsId(): int
    {
        return $this->newsId;
    }
}
