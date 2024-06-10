<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CreateNewsRequest
{
    public function __construct(
        public readonly string $url,
        public readonly string $title,
    ) {} // phpcs:ignore
}
