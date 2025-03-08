<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

use DateTimeImmutable;

class NewsResponseItems
{
    public function __construct(
        public readonly string $title,
        public readonly DateTimeImmutable $date,
        public readonly string $url,
    ) {
        // Empty constructor
    }
}
