<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use DateTimeImmutable;

class AddNewsRequest
{
    public function __construct(
        public string $url
    ) {
    }
}
