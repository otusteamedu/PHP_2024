<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Report;

class GetReportFullFilenameResult
{
    public function __construct(readonly private string $fullFilename)
    {
    }

    public function getFullFilename(): string
    {
        return $this->fullFilename;
    }
}
