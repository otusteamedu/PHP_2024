<?php

namespace App\Application\Bus\Dto;

class NewsItemsIdsBusRequestDto
{
    public function __construct(public string $jsonIds)
    {
    }
}
