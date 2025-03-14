<?php

namespace App\Application\UseCase\GetNews;

use App\Application\TextConverter\TextConverterInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(GetNewsRequest $request, TextConverterInterface $textConverter): GetNewsResponse
    {
        // Получить новость из базы
        $news = $this->newsRepository->findById($request->id);
        if (null === $news) {
            throw new ModelNotFoundException();
        }

        // Переложить новость в DTO, при этом конвертируем текст в заданный формат
        $newsDto = new NewsDTO(
            $news->getId(),
            $news->getTitle()->getValue(),
            $news->getDate(),
            $news->getAuthor()->getValue(),
            $news->getCategory()->getValue(),
            $textConverter->convert($news->getText()),
        );

        // Сформировать и вернуть ответ
        return new GetNewsResponse($newsDto);
    }
}
