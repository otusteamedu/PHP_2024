<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\News;

class GenerateNewsReportResponse
{
    public function __construct(readonly private string $linkToReportFile)
    {
    }

    public function getLinkToReportFile(): string
    {
        return $this->linkToReportFile;
    }
}
