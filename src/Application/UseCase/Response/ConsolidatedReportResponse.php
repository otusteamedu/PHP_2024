<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class ConsolidatedReportResponse
{
    public function __construct(public readonly string $fileUriPath)
    {
    }
}