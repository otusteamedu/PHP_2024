<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class GetNewsRequest
{
    public function __construct(
        public readonly int $id
    ) {} // phpcs:ignore
}
