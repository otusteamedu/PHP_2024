<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

readonly class SubmitNewsRequest
{
    public function __construct(
        public string $url,
    ) {
    }
}
