<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\CreateNews;

use AnatolyShilyaev\Hw15\Domain\Factory\NewsFactoryInterface;
use AnatolyShilyaev\Hw15\Domain\Repository\NewsRepositoryInterface;

class CreateNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        //Create news
        $news = $this->newsFactory->create($request->url);

        //Save news to DB
        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
