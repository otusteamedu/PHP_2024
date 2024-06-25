<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

readonly class ParsedArticleDto
{
    public function __construct(
        public ?string $title = null,
    ) {
    }
}
