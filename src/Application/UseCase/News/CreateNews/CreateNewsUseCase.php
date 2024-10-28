<?php

namespace App\Application\UseCase\News\CreateNews;

use App\Domain\Entity\News;
use App\Domain\Interface\Factory\EntityFactoryInterface;
use App\Domain\Interface\Repository\NewsRepositoryInterface;
use App\Domain\Interface\UseCase\CreateNewsUseCaseInterface;

class CreateNewsUseCase implements CreateNewsUseCaseInterface
{
    public function __construct(
        private readonly EntityFactoryInterface  $factory,
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
