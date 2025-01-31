<?php

namespace Application\UseCase\GetNewsList;

use Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    )
    {
    }

    public function __invoke(): GetNewsListResponse
    {
        // Прочитать все новости из базы
        $newsList = $this->newsRepository->findAll();

        // Сформировать и вернуть ответ
        return new GetNewsListResponse($newsList);
    }

}
