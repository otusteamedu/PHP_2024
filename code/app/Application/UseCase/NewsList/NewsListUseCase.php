<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsList;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

readonly class NewsListUseCase
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(): NewsListResponse
    {
        $newsList = $this->newsRepository->getAll();

        $list = [];
        foreach ($newsList as $news) {
            $list[] = new NewsListItem(
                $news->getId(),
                $news->getTitle()->getValue(),
                $news->getUrl()->getValue(),
                $news->getExportDate()->getValue()->format('Y-m-d H:i')
            );
        }

        return new NewsListResponse($list);
    }
}
