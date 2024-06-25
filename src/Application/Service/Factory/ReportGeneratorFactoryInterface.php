<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Service\DTO\ReportNewsDto;
use App\Domain\Entity\News;

interface ReportGeneratorFactoryInterface
{
    /**
     * @param News[] $newsList
     * @return ReportNewsDto[]
     */
    public function createFromNews(array $newsList): array;
}
