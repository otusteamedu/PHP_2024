<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink;

class GenerateLinkParams
{
    public function __construct(readonly private string $filename)
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
