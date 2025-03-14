<?php

namespace App\Application\UseCase\GetNewsList;

use App\Application\TextConverter\TextConverterInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(TextConverterInterface $textConverter): GetNewsListResponse
    {
        // Прочитать все новости из базы
        $newsList = $this->newsRepository->findAll();

        // Переложить список в массив DTO
        $newsDtoArr = [];
        foreach ($newsList as $news) {
            $newsDtoArr[] = new NewsForListDTO(
                $news->getId(),
                $news->getTitle()->getValue(),
                $news->getDate(),
                $news->getAuthor()->getValue(),
                $news->getCategory()->getValue(),
                $textConverter->convert($news->getText()),
            );
        }

        // Сформировать и вернуть ответ
        return new GetNewsListResponse($newsDtoArr);
    }
}
