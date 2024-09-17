<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

readonly class SubmitNewsResponse
{
    public function __construct(
        public int $id,
    ) {
    }
}
