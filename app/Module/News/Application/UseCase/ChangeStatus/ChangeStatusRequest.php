<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\ChangeStatus;

final readonly class ChangeStatusRequest
{
    public function __construct(
        public string $id,
        public string $status
    ) {
    }
}
