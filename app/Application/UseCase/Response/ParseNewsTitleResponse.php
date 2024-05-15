<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

final readonly class ParseNewsTitleResponse
{
    public function __construct(
        public string $title
    ) {
    }
}
