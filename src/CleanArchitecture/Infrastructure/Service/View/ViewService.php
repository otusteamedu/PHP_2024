<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\View;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto\NewsDto;

class ViewService
{
    /**
     * @param NewsDto[] $newsDtoList
     * @return array
     */
    public function prepareNews(array $newsDtoList): array
    {
        return array_map(function (NewsDto $news) {
            return [
                'id' => $news->getId(),
                'createdAt' => $news->getCreatedAt()->format('d-m-Y H:i:s'),
                'url' => $news->getUrl(),
                'title' => $news->getTitle(),
            ];
        }, $newsDtoList);
    }
}
