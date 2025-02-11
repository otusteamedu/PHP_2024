<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetListNews;

readonly class GetListNewsResponse
{
    public function __construct(
        private array $news,
    )
    {
    }

    public function getNews(): iterable
    {
        return $this->news;
    }
}