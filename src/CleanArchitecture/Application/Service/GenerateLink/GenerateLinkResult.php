<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink;

class GenerateLinkResult
{
    public function __construct(readonly private string $linkToFile)
    {
    }

    public function getLinkToFile(): string
    {
        return $this->linkToFile;
    }
}
