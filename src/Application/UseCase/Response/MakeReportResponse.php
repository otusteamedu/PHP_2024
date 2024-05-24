<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class MakeReportResponse
{
    public function __construct(public string $filePath)
    {
    }
}