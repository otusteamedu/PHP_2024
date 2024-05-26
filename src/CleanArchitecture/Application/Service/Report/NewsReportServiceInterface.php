<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Report;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

interface NewsReportServiceInterface
{
    /**
     * @param News[] $news
     * @return string filename
     */
    public function generateReport(array $news): string;

    /**
     * @throws ReportFileNotFoundException
     */
    public function getReportFullFilename($filename): string;
}