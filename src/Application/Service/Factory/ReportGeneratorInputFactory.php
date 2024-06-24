<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Service\DTO\ReportGeneratorInputDto;
use App\Application\Service\DTO\ReportNewsDto;
use App\Domain\Entity\News;

class ReportGeneratorInputFactory
{
    /**
     * @param News[] $newsList
     * @return ReportGeneratorInputDto
     */
    public function createFromNews(array $newsList): ReportGeneratorInputDto
    {
        $newsDtoList = array_map(
            static fn(News $news) => new ReportNewsDto($news->getTitle(), $news->getUrl()),
            $newsList,
        );

        return new ReportGeneratorInputDto($newsDtoList);
    }
}
