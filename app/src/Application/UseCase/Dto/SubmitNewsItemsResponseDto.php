<?php

namespace App\Application\UseCase\Dto;

use App\Domain\Entity\NewsItem;

class SubmitNewsItemsResponseDto
{
    private readonly iterable $newsItems;

    public function __construct(NewsItem ...$newsItems)
    {
        $this->newsItems = $newsItems;
    }

    public function getNewsItems(): iterable
    {
        return $this->newsItems;
    }
}
