<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Request;

class GetNewsReportRequest
{
    private mixed $filename;

    public function __construct(mixed $filename)
    {
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return (string)$this->filename;
    }
}