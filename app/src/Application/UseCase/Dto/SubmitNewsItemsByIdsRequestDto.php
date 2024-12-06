<?php

declare(strict_types=1);

namespace App\Application\UseCase\Dto;

class SubmitNewsItemsByIdsRequestDto
{
    public function __construct(public array $ids)
    {
    }
}
