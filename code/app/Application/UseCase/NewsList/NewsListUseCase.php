<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsList;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class NewsListUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository) {}

    public function __invoke(): NewsListResponse
    {
        $newsList = $this->newsRepository->getAll();

        return new NewsListResponse($newsList);
    }
}
