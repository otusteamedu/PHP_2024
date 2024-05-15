<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

final readonly class ParseNewsTitleRequest
{
    public function __construct(
        public string $url
    ) {
    }
}
