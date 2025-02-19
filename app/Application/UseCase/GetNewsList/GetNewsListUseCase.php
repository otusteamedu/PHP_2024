<?php

namespace App\Application\UseCase\GetNewsList;

use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(): GetNewsListResponse
    {
        // Прочитать все новости из базы
        $newsList = $this->newsRepository->findAll();

        // Переложить список в массив DTO
        $newsDtoArr = [];
        foreach ($newsList as $news) {
            $newsDtoArr[] = new NewsDTO(
                $news->getId(),
                $news->getTitle()->getValue(),
                $news->getUrl()->getValue(),
                $news->getDate()
            );
        }

        // Сформировать и вернуть ответ
        return new GetNewsListResponse($newsDtoArr);
    }
}
