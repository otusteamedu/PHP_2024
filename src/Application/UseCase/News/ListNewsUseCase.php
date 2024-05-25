<?php

declare(strict_types=1);

namespace App\Application\UseCase\News;

use App\Application\UseCase\News\DTO\ListNewsResponse;
use App\Domain\Entity\News\{News, NewsRepositoryInterface};

class ListNewsUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(): array
    {
        return $this->newsRepository->all()
            ->map(function (News $news) {
                new ListNewsResponse(
                    $news->getId(),
                    $news->getDate(),
                    $news->getTitle(),
                    $news->getUrl(),
                );
            })->all();
    }
}
