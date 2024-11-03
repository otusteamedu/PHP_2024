<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

class CreateNewsReportResponse
{
    public function __construct(public readonly string $filePath)
    {
    }
}
