<?php

namespace App\Application\UseCase\News\CreateNews;

use App\Domain\Contract\Application\UseCase\CreateNewsUseCaseInterface;
use App\Domain\Contract\Infrastructure\Factory\EntityFactoryInterface;
use App\Domain\Contract\Infrastructure\Repository\NewsRepositoryInterface;
use App\Domain\Entity\News;

class CreateNewsUseCase implements CreateNewsUseCaseInterface
{
    public function __construct(
        /** @var EntityFactoryInterface<News> */
        private readonly EntityFactoryInterface $factory,
        /** @var NewsRepositoryInterface<News> */
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(CreateNewsUseCaseRequest $request): CreateNewsUseCaseResponse
    {
        return new CreateNewsUseCaseResponse($this->createNews($request));
    }

    private function createNews(CreateNewsUseCaseRequest $request): int
    {
        $news = $this->factory->makeEntity(News::class, $request->url, $request->tile);

        return $this->newsRepository->create($news)->getId();
    }
}
