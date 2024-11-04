<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNewsList;

use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository
    ) {
    }

    public function __invoke(): GetNewsListResponse
    {
        $result = [];

        $newsList = $this->newsRepository->findAll();

        foreach ($newsList as $oneNews) {
            $result[] = [
            'id' => $oneNews->getId(),
            'date' => $oneNews->getDate()->getValue()->format("Y-m-d H:i:s"),
            'url' => $oneNews->getUrl()->getValue(),
            'title' => $oneNews->getTitle()->getValue()
            ];
        }

        return new GetNewsListResponse($result);
    }
}
