<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class GenerateReportResponse
{
    public function __construct(
        public readonly string $link
    ) {}
}