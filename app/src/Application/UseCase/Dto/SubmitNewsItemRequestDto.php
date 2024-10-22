<?php

declare(strict_types=1);

namespace App\Application\UseCase\Dto;

class SubmitNewsItemRequestDto
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
