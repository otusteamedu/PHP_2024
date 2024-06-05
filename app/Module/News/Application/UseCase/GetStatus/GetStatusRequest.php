<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetStatus;

final readonly class GetStatusRequest
{
    public function __construct(
        public string $id,
    ) {
    }
}
