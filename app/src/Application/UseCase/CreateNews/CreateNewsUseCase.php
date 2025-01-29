<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\CreateNews;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

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
