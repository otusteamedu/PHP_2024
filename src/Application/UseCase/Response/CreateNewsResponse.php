<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class CreateNewsResponse
{
    public function __construct(
        public readonly int $id
    ) {} // phpcs:ignore
}
