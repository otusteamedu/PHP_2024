<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Dto;

use Stringable;

readonly final class Message implements Stringable
{
    public function __construct(
        public string $newsId,
        public string $status,
    ) {
    }

    public function __toString(): string
    {
        return json_encode([
            'newsId' => $this->newsId,
            'status' => $this->status
        ]);
    }
}
