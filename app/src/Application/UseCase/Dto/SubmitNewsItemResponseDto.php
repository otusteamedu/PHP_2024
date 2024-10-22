<?php

declare(strict_types=1);

namespace App\Application\UseCase\Dto;

class SubmitNewsItemResponseDto
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
