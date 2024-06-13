<?php

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Report;

class GetReportFullFilenameParams
{
    public function __construct(readonly private string $filename)
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
