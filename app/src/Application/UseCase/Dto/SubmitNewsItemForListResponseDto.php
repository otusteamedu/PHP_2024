<?php

namespace App\Application\UseCase\Dto;

class SubmitNewsItemForListResponseDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $url,
        public readonly \DateTimeImmutable $date
    )
    {
    }
}