<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\FindAllNews;

use AnatolyShilyaev\Hw15\Domain\Factory\NewsFactoryInterface;
use AnatolyShilyaev\Hw15\Domain\Repository\NewsRepositoryInterface;

class FindAllNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(): FindAllNewsResponse
    {
        //get all News
        $news = $this->newsRepository->findAll();
        return new FindAllNewsResponse($news);
    }
}
