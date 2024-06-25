<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Service\DTO\ReportNewsDto;
use App\Domain\Entity\News;

class ReportGeneratorInputFactory implements ReportGeneratorFactoryInterface
{
    /**
     * @param News[] $newsList
     * @return ReportNewsDto[]
     */
    public function createFromNews(array $newsList): array
    {
        return array_map(
            static fn(News $news) => new ReportNewsDto($news->getTitle(), $news->getUrl()),
            $newsList,
        );
    }
}
