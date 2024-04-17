<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class GetNewsResponse
{
    public function __construct(
        public readonly string $status
    ) {} // phpcs:ignore
}
