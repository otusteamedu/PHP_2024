<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\DTO;

class ExportedReport
{
    public function __construct(public readonly string $format, public readonly string $path)
    {
    }
}
