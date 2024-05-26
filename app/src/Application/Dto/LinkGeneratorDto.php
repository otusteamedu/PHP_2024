<?php

declare(strict_types=1);

namespace App\Application\Dto;

readonly class LinkGeneratorDto
{
    public function __construct(
        public string $url,
    ) {
    }
}
