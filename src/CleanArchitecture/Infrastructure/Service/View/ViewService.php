<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\View;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

class ViewService
{
    /**
     * @param News[] $news
     * @return array
     */
    public function prepareNews(array $news): array
    {
        return array_map(function (News $news) {
            return [
                'id' => $news->getId(),
                'createdAt' => $news->getCreatedAt()->format('d-m-Y H:i:s'),
                'url' => $news->getUrl(),
                'title' => $news->getTitle(),
            ];
        }, $news);
    }
}
