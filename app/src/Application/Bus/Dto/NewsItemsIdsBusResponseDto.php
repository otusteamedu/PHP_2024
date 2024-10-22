<?php

namespace App\Application\Bus\Dto;

class NewsItemsIdsBusResponseDto
{
    public function __construct(public array $arIds)
    {
    }
}
