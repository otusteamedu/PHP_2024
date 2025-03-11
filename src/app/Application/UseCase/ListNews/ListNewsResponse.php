<?php

namespace App\Application\UseCase\ListNews;

use App\Domain\Entity\News;

class ListNewsResponse
{
    /**
     * @param News[] $news
     */
    public function __construct(public array $news)
    {
    }
}
