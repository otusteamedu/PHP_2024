<?php

declare(strict_types=1);

namespace App\Application\Parser;

class NewsParseResult
{
    public function __construct(
        public string $title
    ) {
    }
}
