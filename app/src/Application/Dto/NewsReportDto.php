<?php

declare(strict_types=1);

namespace App\Application\Dto;

class NewsReportDto
{
    public function __construct(
        public string $content,
        public string $name,
        public string $extension,
    ) {
    }

    public function getFilename(): string
    {
        return sprintf('%s.%s', $this->name, $this->extension);
    }
}
