<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNewsList;

use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @return GetNewsListResponse[]
     */
    public function __invoke(): array
    {
        $newsList = $this->newsRepository->findAll();
        $response = [];

        foreach ($newsList as $news) {
            $response[] = new GetNewsListResponse(
                $news->getId(),
                $news->getDate()->getValue()->format('Y-m-d H:i:s'),
                $news->getUrl()->getValue(),
                $news->getTitle()->getValue()
            );
        }

        return $response;
    }
}
