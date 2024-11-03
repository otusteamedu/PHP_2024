<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class ReportFile
{
    public function __construct(
        private string $path
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
