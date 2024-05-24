<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class ConsolidatedReportResponse
{
    public function __construct(public string $fileUriPath)
    {
    }
}