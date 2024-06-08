<?php

declare(strict_types=1);

namespace App\Application\Dto;

readonly class DomParserDto
{
    public function __construct(
        public string $tagText,
    ) {
    }
}
