<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\Report;

class GetNewsReportResponse
{
    public function __construct(readonly private string $reportFullFilename)
    {
    }

    public function getReportFullFilename(): string
    {
        return $this->reportFullFilename;
    }
}
