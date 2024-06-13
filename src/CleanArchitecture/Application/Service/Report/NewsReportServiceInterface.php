<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Report;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto\NewsDto;

interface NewsReportServiceInterface
{
    /**
     * @param NewsDto[] $newsDtoList
     */
    public function generateReport(array $newsDtoList): GenerateReportResult;

    /**
     * @throws ReportFileNotFoundException
     */
    public function getReportFullFilename(GetReportFullFilenameParams $params): GetReportFullFilenameResult;
}
