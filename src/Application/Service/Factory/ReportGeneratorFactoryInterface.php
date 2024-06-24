<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Service\DTO\ReportGeneratorInputDto;

interface ReportGeneratorFactoryInterface
{
    public function createFromNews(array $newsList): ReportGeneratorInputDto;
}
