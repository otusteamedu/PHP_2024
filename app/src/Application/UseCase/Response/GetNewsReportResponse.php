<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class GetNewsReportResponse
{
    public function __construct(public string $url, public array $warnings = [])
    {
    }
}
