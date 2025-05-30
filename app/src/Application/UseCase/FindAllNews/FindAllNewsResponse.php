<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

use DateTimeImmutable;

class FindAllNewsResponse
{
    public function __construct(
        public readonly string $title,
        public readonly string $url,
        public readonly DateTimeImmutable $date
    ) {
        // Empty constructor
    }
}
