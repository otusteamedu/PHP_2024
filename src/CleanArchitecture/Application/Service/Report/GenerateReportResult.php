<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Report;

class GenerateReportResult
{
    public function __construct(readonly private string $filename)
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
