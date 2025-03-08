<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use DateTimeImmutable;

class FindAllNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(): iterable
    {
        //Get all News
        $news = $this->newsRepository->findAll();

        // Create DTO array
        $newsArr = [];
        foreach ($news as $new) {
            $newsArr[] = new NewsResponseItems($new["title"], new DateTimeImmutable($new["date"]), $new["url"]);
        }

        return $newsArr;
    }
}
