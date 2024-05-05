<?php

declare(strict_types=1);

namespace App\Domain\DataProvider;

use App\Domain\Entity\News\News;
use App\Domain\Entity\News\NewsRepositoryInterface;
use App\Domain\ValueObject\ReportLine;

class ReportDataProvider
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function __invoke(int ...$ids): array
    {
        $news = $this->newsRepository->findWhereIn($ids);

        return array_map(
            static fn (News $news) => new ReportLine($news->getUrl(), $news->getTitle()),
            $news->all()
        );
    }
}
