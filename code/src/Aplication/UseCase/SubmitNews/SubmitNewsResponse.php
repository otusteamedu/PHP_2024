<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\SubmitNews;

use Asyrovatkin\Hw14\Domain\Entity\News;

class SubmitNewsResponse
{
    private readonly News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function getNews(): News
    {
        return $this->news;
    }
}