<?php

declare(strict_types=1);

namespace App\Application\UseCase\Dto;

class SubmitNewsListResponseDto
{
    public function __construct(public array $newsList)
    {
    }
}
