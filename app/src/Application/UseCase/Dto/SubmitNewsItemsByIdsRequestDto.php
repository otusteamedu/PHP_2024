<?php

namespace App\Application\UseCase\Dto;

class SubmitNewsItemsByIdsRequestDto
{
    public function __construct(public string $jsonIds)
    {
    }
}
