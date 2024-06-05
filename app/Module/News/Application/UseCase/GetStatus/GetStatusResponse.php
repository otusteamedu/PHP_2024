<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetStatus;

final readonly class GetStatusResponse
{
    public function __construct(
        public string $status
    ) {
    }
}
