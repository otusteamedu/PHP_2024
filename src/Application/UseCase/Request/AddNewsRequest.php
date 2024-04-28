<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class AddNewsRequest
{
    public function __construct(
        public string $url,
    ) {
    }
}
