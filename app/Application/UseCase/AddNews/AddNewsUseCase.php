<?php

namespace App\Application\UseCase\AddNews;

use App\Domain\Builder\NewsBuilder;
use App\Domain\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        // Создать News с помощью builder
        $news = (new NewsBuilder())
            ->setTitle($request->title)
            ->setDate(new \DateTimeImmutable())
            ->setAuthor($request->author)
            ->setCategory($request->category)
            ->setText($request->text)
            ->build();

//        $news = $this->newsFactory->create(
//            $request->title,
//            new \DateTimeImmutable(),
//            $request->author,
//            $request->category,
//            $request->text
//        );

        // Сохранить в БД
        $this->newsRepository->save($news);

        // Сформировать и вернуть ответ
        return new AddNewsResponse($news->getId());
    }
}
