<?php

declare(strict_types=1);

namespace App\Application\Dto;

class LinkDto
{
    public function __construct(
        public string $filename,
    ) {
    }
}
