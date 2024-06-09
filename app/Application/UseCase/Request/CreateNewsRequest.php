<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

final readonly class CreateNewsRequest
{
    public function __construct(
        public string $date,
        public string $title,
        public string $url
    ) {
    }
}
