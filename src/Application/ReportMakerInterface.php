<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\News;

interface ReportMakerInterface
{
    /**
     * @param News[] $newsList
     * @return string
     */
    public function makeReport(array $newsList): string;
}