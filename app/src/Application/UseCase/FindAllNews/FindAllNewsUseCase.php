<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class FindAllNewsUseCase
{

    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {}

    public function __invoke(): FindAllNewsResponse
    {
        //get all News
        $news = $this->newsRepository->findAll();
        return new FindAllNewsResponse($news);
    }
}
