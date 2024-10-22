<?php

declare(strict_types=1);

namespace App\Application\Bus\Dto;

class NewsItemUrlBusRequestDto
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
