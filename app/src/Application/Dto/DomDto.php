<?php

declare(strict_types=1);

namespace App\Application\Dto;

class DomDto
{
    public function __construct(
        public string $url,
        public string $tag,
    ) {
    }
}
