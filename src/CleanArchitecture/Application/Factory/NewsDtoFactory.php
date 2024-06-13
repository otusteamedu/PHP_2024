<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Factory;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto\NewsDto;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

class NewsDtoFactory
{
    public function createFromNews(News $news): NewsDto
    {
        return new NewsDto(
            $news->getId(),
            $news->getCreatedAt(),
            $news->getUrl()->getValue(),
            $news->getTitle()->getValue()
        );
    }

    /**
     * @return NewsDto[]
     */
    public function createFromNewsList(array $newsList): array
    {
        return array_map(function (News $news) {
            return $this->createFromNews($news);
        }, $newsList);
    }
}
